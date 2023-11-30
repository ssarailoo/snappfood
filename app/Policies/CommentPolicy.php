<?php

namespace App\Policies;

use App\Enums\CommentStatus;
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
        return $user->hasRole('admin') or $user->restaurant->is($restaurant)  ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment,Restaurant $restaurant): bool
    {

        return $user->hasRole('admin') or $user->restaurant->is($restaurant) and $restaurant->comments->contains($comment)  ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Comment $comment=null): bool
    {
        if ($comment!==null and $comment->parent_id)
            return false;

        return $user->hasRole('admin') or $user->orders->contains(Order::query()->find(\request()->post('order_id'))) or
            $user->restaurant->comments->contains($comment) ;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment, $newStatus): bool
    {
        $currentStatus = $comment->status;
        $allowedTransitions = [
            CommentStatus::PENDING->value => [CommentStatus::Accepted->value, CommentStatus::REVIEWING_BY_ADMIN->value],
            CommentStatus::REVIEWING_BY_ADMIN->value =>[ CommentStatus::Accepted->value,CommentStatus::RECONSIDERING_BY_CUSTOMER->value],
            CommentStatus::RECONSIDERING_BY_CUSTOMER->value=>[CommentStatus::Accepted->value]
        ];
        if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return false;
        }
        return  $user->hasRole('admin') or $user->restaurant->comments->contains($comment) ;
    }

    public function reconsider(User $user,Comment $comment)
    {
        return $user->carts->map(fn($cart)=>$cart->comments->first())->contains($comment) and
            $comment->status===CommentStatus::RECONSIDERING_BY_CUSTOMER->value and
            $comment->reconsidered===0;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin') and  $comment->reconsidered===1 ;
    }


}
