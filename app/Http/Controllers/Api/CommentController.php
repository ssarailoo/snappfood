<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use App\Http\Requests\Comment\GetCommentsRequest;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Comment;
use App\Services\Comment\CommentBearerService;
use App\Services\Comment\CommentStoreService;

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
        if ($request->wantsJson()) {
            $response = $service->getComments($request);
            return  isset($response['msg']) ? response($response, 400) : response($response, 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @group Comment
     * Store a newly created resource in storage.
     *
     */
    public function store(StoreCommentRequest $request, CommentStoreService $commentStoreService)
    {

        $this->authorize('create', [Comment::class, $request]);
        $response = $commentStoreService->storeComment($request, $request->post('cart_id'));
        if (isset($response['success']))
            return response($response, 201);
        return response($response, 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
