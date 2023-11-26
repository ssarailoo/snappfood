<?php

namespace App\Http\Controllers\Web;

use App\Enums\CommentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreReplyCommentRequest;
use App\Http\Requests\Comments\FilterCommentRequest;
use App\Models\Comment;
use App\Models\Restaurant\Restaurant;


class CommentController extends Controller
{
    public function index(Restaurant $restaurant, FilterCommentRequest $request)
    {

        $this->authorize('viewAny', [Comment::class, $restaurant]);
        $comments = $restaurant->carts->map(fn($cart) => $cart->comments->first());
        $filter = $request->get('status');

        return view('comment.index', [
            'comments' => $comments->when(!empty($filter), function ($query) use ($filter) {
                return $query->filter(fn($comment) => $comment->status === $filter);
            }),
            'restaurant' => $restaurant
        ]);
    }

    public function show(Restaurant $restaurant, Comment $comment)
    {
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
            'cart' => $comment->cart
        ]);

    }

    public function store(Restaurant $restaurant, Comment $comment, StoreReplyCommentRequest $request)
    {
        $this->authorize('create', $comment);

        Comment::query()->updateOrCreate(
            ['parent_id' => $comment->id],
            $request->validated()
        );
        $shortId = substr($comment->cart->hashed_id, 0, 10);
        return redirect()->route('my-restaurant.comments.index', $restaurant)->with('success', "reply comment added to Shopping cart with ID {$shortId}");


    }

    public function update(Restaurant $restaurant, Comment $comment, $newStatus)
    {
        $this->authorize('update', [$comment, $newStatus]);
        $comment->update([
            'status' => $newStatus,
        ]);
        $shortId = substr($comment->cart->hashed_id, 0, 10);
        return redirect()->back()->with('success', "Shopping cart status comment with ID {$shortId} has been updated to $newStatus");

    }

    public function destroy( Comment $comment)
    {
        $this->authorize('delete',$comment);
        $comment->delete();
        return redirect()->route('comments.review');

    }

    public function review()
    {
        return view('comment.review', [
            'comments' => Comment::query()->where('status', CommentStatus::REVIEWING_BY_ADMIN)->get()
        ]);
    }
}
