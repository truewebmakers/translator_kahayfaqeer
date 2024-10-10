<?php

namespace App\Helpers;

use App\Models\BookTranslationComments;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserHelper
{
    public static function userRole()
    {
        $user =  User::find(Auth::id());
        return Auth::check() ? $user->getRoleNames()[0] : collect();
    }
    public static function userCan($permissions, $all = true)
    {
        // Retrieve the current user
        $user =  User::find(Auth::id());
        // Check if the user has the permissions
        if ($all) {
            // Check if the user has all the permissions
            return collect($permissions)->every(fn($permission) => $user->can($permission));
        } else {
            // Check if the user has at least one of the permissions
            return collect($permissions)->contains(fn($permission) => $user->can($permission));
        }
    }
    public static function LastUserLevel($level)
    {
        $userLevel = Auth::user()->user_level;
        if(empty( $userLevel) ||  $userLevel == 'admin'){
            return true;
        }else if($level == $userLevel){
            return true;
        }
        return false;

    }

}



