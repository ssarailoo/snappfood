<?php

namespace App\Http\Controllers\Web;

use App\Enums\CommentStatus;
use App\Events\CommentReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreReplyCommentRequest;
use App\Http\Requests\Comment\UpdateCommentDescriptionRequest;
use App\Http\Requests\Comments\FilterCommentRequest;
use App\Models\Comment;
use App\Models\Restaurant\Restaurant;
use App\Services\Comment\CommentFilterService;
use App\Services\Restaurant\RestaurantUpdateScoreService;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;


class CommentController extends Controller
{
    public function index(Restaurant $restaurant, FilterCommentRequest $request, CommentFilterService $service)
    {

        $this->authorize('viewAny', [Comment::class, $restaurant]);
        $comments = $restaurant->orders->load(['comments.order.user', 'comments.order.foodsOrder', 'comments.order'])
            ->map(fn($order) => $order->comments->first())->filter(fn($comment) => $comment !== null)->sortByDesc('created_at');
        $filteredComments = $service->filter($comments);
        $perPage = 10;
        $page = request()->get('page', 1);
        $paginator = new LengthAwarePaginator(
            $filteredComments->forPage($page, $perPage),
            $filteredComments->count(),
            $perPage,
            $page,
            ['path' => url()->current()]
        );
        return view('comment.index', [
            'comments' => $paginator,
            'restaurant' => $restaurant
        ]);
    }

    public function show(Restaurant $restaurant, Comment $comment)
    {
        $this->authorize('view', [$comment, $restaurant]);
        return view('comment.show', [
            'comment' => $comment,
            'restaurant' => $restaurant
        ]);

    }

    public function create(Restaurant $restaurant, Comment $comment)
    {
        $this->authorize('create', $comment);
        return view('comment.create', [
            'comment' => $comment,
            'order' => $comment->order,
            'restaurant' => $restaurant
        ]);

    }

    public function store(Restaurant $restaurant, Comment $comment, StoreReplyCommentRequest $request)
    {
        $this->authorize('create', $comment);
        try {
            Comment::query()->updateOrCreate(
                ['parent_id' => $comment->id],
                $request->validated()
            );
        } catch (QueryException $e) {
            Log::error("Error Creating Reply Comment");
        }
        return redirect()->route('my-restaurant.comments.index', $restaurant)->with('success', "reply comment added ");
    }

    public function update(UpdateCommentDescriptionRequest $request, Restaurant $restaurant, Comment $comment, $newStatus, RestaurantUpdateScoreService $service)
    {
        $this->authorize('update', [$comment, $newStatus]);
        try {
            $comment->update([
                'status' => $newStatus,
                'description' => $request->description ?? null
            ]);
        } catch (QueryException $e) {
            Log::error("Error Updating Comment");
        }

        event(new CommentReview($comment));
        $service->updateRestaurantScore($restaurant, $newStatus);
        return redirect()->back()->with('success', " status  has been updated to $newStatus");

    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        try {
            $comment->delete();
        } catch (QueryException $e) {
            Log::error("Error Deleting Comment");
        }
        return redirect()->route('comments.review');

    }

    public function review(FilterCommentRequest $request, CommentFilterService $service)
    {
        $comments = Comment::query()->with(['order', 'order.user', 'order.foodsOrder'])->whereNotIn('status', [CommentStatus::Accepted->value, CommentStatus::PENDING->value])
            ->get()->sortByDesc('updated_at');
        $filteredComments = $service->filter($comments);
        $perPage = 10;
        $page = request()->get('page', 1);
        $paginator = new LengthAwarePaginator(
            $filteredComments->forPage($page, $perPage),
            $filteredComments->count(),
            $perPage,
            $page,
            ['path' => url()->current()]
        );
        return view('comment.review', [
            'comments' => $paginator
        ]);
    }

    public function getUpdatedComments()
    {
        $comments = Comment::query()
            ->whereNotIn('status', [CommentStatus::Accepted->value, CommentStatus::PENDING->value])
            ->get()
            ->sortByDesc('updated_at');

        return view('comment.new', [
            'comments' => $comments
        ]);

    }
}
