<?php

namespace App\Http\Controllers\Api;

use App\Enums\CommentStatus;
use App\Events\CommentReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\GetCommentsRequest;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\Comment\DeniedCommentResource;
use App\Models\Comment;
use App\Services\Comment\CommentBearerService;
use App\Services\Comment\CommentStoreService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/*
 * @group comment
 *
 */

class CommentController extends Controller
{
    /**
     * @group Comment
     * Display a listing of the resource.
     * @queryParam restaurant_id integer required
     *
     */
    public function index(GetCommentsRequest $request, CommentBearerService $service)
    {

        $response = $service->getComments($request);
        return response()->json([
            'data' => $response
        ], 200);

    }


    /**
     * @group Comment
     * Store a newly created resource in storage.
     *
     */
    public function store(StoreCommentRequest $request)
    {

        $this->authorize('create', Comment::class);
        try {
            Comment::query()->create($request->validated());
        } catch (QueryException $e) {
            Log::error('Error Creating new Comment ' . $e->getMessage());
            return response()->json([
                'data' => [
                    'error' => 'An unexpected error occurred'
                ]
            ]);
        }
        return response()->json([
            'data' => [
                'success' => true,
                'message' => "comment created successfully."
            ]
        ]);


    }

    public function showDeniedComments()
    {
        $comments = Auth::user()->orders->map(fn($order) => $order->comments->first())->filter(fn($comment) => $comment !== null)->
        filter(fn($comment) => $comment->status === CommentStatus::RECONSIDERING_BY_CUSTOMER->value and $comment->reconsidered === 0);

        return response()->json([
            'data' => ['comments' => DeniedCommentResource::collection($comments)]
        ]);

    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $this->authorize('reconsider', $comment);
        try {
            $comment->update([
                'score' => $request->input('score'),
                'content' => $request->input('content'),
                'reconsidered' => 1
            ]);
            event(new CommentReview($comment));
        } catch (QueryException $e) {
            Log::error('Error Reconsidering Comment ' . $e->getMessage());
            return response()->json([
                'data' => [
                    'error' => "An unexpected error occurred"
                ]
            ]);
        }
        return response()->json([
            'data' => [
                'message' => "your comment has been updated successfully and waiting for Admin confirmation"
            ]
        ]);
    }

}
