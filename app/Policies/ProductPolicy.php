<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User|null $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param  \App\Models\Product  $product
     * @return Response|bool
     */
    public function view(?User $user, Product $product)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        return in_array($user->role_id, [1, 2]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param  \App\Models\Product  $product
     * @return Response|bool
     */
    public function update(User $user, Product $product)
    {
        return $user->role_id == 1 || $user->id == $product->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param  \App\Models\Product  $product
     * @return Response|bool
     */
    public function delete(User $user, Product $product)
    {
        return $user->role_id == 1 || $user->id == $product->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param  \App\Models\Product  $product
     * @return Response|bool
     */
    public function restore(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param  \App\Models\Product  $product
     * @return Response|bool
     */
    public function forceDelete(User $user, Product $product)
    {
        //
    }
}
