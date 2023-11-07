<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\GetCommentsRequest;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\Comment\CommentCollection;
use App\Models\Cart\Cart;
use App\Models\Comment;
use App\Models\Restaurant\Restaurant;
use App\Services\CommentStoreService;

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
    public function index(GetCommentsRequest $request)
    {
        if ($request->wantsJson()) {
            return response(new CommentCollection(Restaurant::query()->find($request->get('restaurant_id'))->comments->filter(function ($comment) {
                return $comment->parent_id === null;
            })), 200);
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
