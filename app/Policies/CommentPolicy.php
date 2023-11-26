<?php

namespace App\Policies;

use App\Enums\CommentStatus;
use App\Models\Cart\Cart;
use App\Models\Comment;
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
        return $user->restaurant->is($restaurant) or $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Restaurant $restaurant): bool
    {
        return $user->restaurant->is($restaurant) or $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Comment $comment = null): bool
    {
        return $user->carts->contains(Cart::query()->find(\request()->post('cart_id'))) or
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
            CommentStatus::REVIEWING_BY_ADMIN->value =>[ CommentStatus::Accepted->value,CommentStatus::RECONSIDERING_BY_CUSTOMER->value],
        ];
        if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return false;
        }
        return $user->restaurant->carts->map(fn($cart) => $cart->comments()->first())->contains($comment) or $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin');
    }
}
