<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        $response = $service->getComments($request);
        return isset($response['msg']) ? response()->json([
            'data' => $response
        ], 400) : response()->json([
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

        $this->authorize('create', [Comment::class, $request]);
        $response = $commentStoreService->storeComment($request, $request->post('cart_id'));
        if (isset($response['success']))
            return response()->json([
                'data' => $response
            ], 201);
        return response()->json([
            'data' => $response
        ], 400);
    }


}
