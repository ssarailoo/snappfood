<?php

namespace App\Http\Controllers\Api;

use App\Enums\CommentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\GetCommentsRequest;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\Comment\DeniedCommentResource;
use App\Models\Comment;
use App\Services\Comment\CommentBearerService;
use App\Services\Comment\CommentStoreService;
use Illuminate\Support\Facades\Auth;

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
        return  response()->json([
            'data' => $response
        ], 200);

    }


    /**
     * @group Comment
     * Store a newly created resource in storage.
     *
     */
    public function store(StoreCommentRequest $request, CommentStoreService $commentStoreService)
    {

        $this->authorize('create', Comment::class);
        $response = $commentStoreService->storeComment($request, $request->post('order_id'));
        if (isset($response['success']))
            return response()->json([
                'data' => $response
            ], 201);
        return response()->json([
            'data' => $response
        ], 400);
    }

    public function showDeniedComments()
    {
        $comments = Auth::user()->carts->map(fn($cart) => $cart->comments->first())->filter(fn($comment) => $comment !== null)->
        filter(fn($comment) =>  $comment->status === CommentStatus::RECONSIDERING_BY_CUSTOMER->value and $comment->reconsidered===0);

        return response()->json([
            'data' =>[ 'comments'=> DeniedCommentResource::collection($comments)]
        ]);

    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $this->authorize('reconsider', $comment);
        $comment->update([
            'score' => $request->input('score'),
            'content' => $request->input('content'),
            'reconsidered' => 1
        ]);
        return response()->json([
            'data' => [
                'msg' => "your comment has been updated successfully and waiting for Admin confirmation"
            ]
        ]);
    }

}
