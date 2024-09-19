<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;


function CurrentUserRole()
{
    $user =  User::find(Auth::id());
    return Auth::check() ? $user->getRoleNames() : collect();
}


function UserCan($permission): mixed
{
    $user =  User::find(Auth::id());
    return Auth::check() ? $user->can($permission) : false;
}
