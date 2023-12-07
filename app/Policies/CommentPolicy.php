<?php

namespace App\Policies;

use App\Enums\CommentStatus;
use App\Enums\OrderStauts;
use App\Models\Cart\Cart;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Restaurant\Restaurant;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole('admin') or $user->restaurant->is($restaurant);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment, Restaurant $restaurant): bool
    {

        return $user->hasRole('admin') or $user->restaurant->is($restaurant) and $restaurant->comments->contains($comment);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Comment $comment = null)
    {
        //Api
        if ($comment === null) {
            $order = Order::query()->find(\request()->post('order_id'));
            if (!$user->orders->contains($order))
                return Response::deny('This order does not belong to you')->withStatus(403);
            if (($order->comments()->withTrashed()->first() !== null))
                return Response::deny('You already have registered your opinion')->withStatus(403);
            if (($order->status !== OrderStauts::DELIVERED->value))
                return Response::deny('Your order has not been delivered yet')->withStatus(403);
            return Response::allow();
        }
        //Web
        if ($comment->parent_id)
            return false;

        return $user->hasRole('admin') or
            $user->restaurant->comments->contains($comment);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment, $newStatus): bool
    {
        $currentStatus = $comment->status;
        $allowedTransitions = [
            CommentStatus::PENDING->value => [CommentStatus::Accepted->value, CommentStatus::REVIEWING_BY_ADMIN->value],
            CommentStatus::REVIEWING_BY_ADMIN->value => [CommentStatus::Accepted->value, CommentStatus::RECONSIDERING_BY_CUSTOMER->value],
            CommentStatus::RECONSIDERING_BY_CUSTOMER->value => [CommentStatus::Accepted->value]
        ];
        if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return false;
        }
        return $user->hasRole('admin') or $user->restaurant->comments->contains($comment);
    }

    public function reconsider(User $user, Comment $comment): Response
    {
        if (!($comment->status === CommentStatus::RECONSIDERING_BY_CUSTOMER->value and $comment->reconsidered === 0))
            return Response::deny('You can not reconsider this comment')->withStatus(403);
        if (!$user->orders->map(fn($order) => $order->comments->first())->contains($comment))
            return Response::deny('this Comment does not belong to you.')->withStatus(403);

        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin') and $comment->status === CommentStatus::RECONSIDERING_BY_CUSTOMER->value and $comment->reconsidered === 1;
    }


}
