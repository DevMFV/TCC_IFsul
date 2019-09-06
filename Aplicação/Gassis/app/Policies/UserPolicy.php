<?php

namespace App\Policies;

use App\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Entities\User  $user
     * @return mixed
     */
    
    public function create(User $user){
        if($user->permission == 4){
            return true;
        }
    }
}
