<?php

namespace App\Helpers;

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
        $user =  User::find(Auth::id());
        if ($all) {
            return collect($permissions)->every(fn($permission) => $user->can($permission));
        } else {
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
    public static function getListingContent($listing, $language) {
        switch($language) {
            case 'urdu':
                return $listing->urdu;
            case 'english':
                return $listing->english;
            case 'arabic':
                return $listing->arabic;
            case 'hindi':
                return $listing->hindi;
            case 'indonesian':
                return $listing->indonesian;
            case 'bengali':
                return $listing->bengali;
            case 'persian':
                return $listing->persian;
            case 'turkish':
                return $listing->turkish;
            default:
                return $listing->english;
        }
    }

}



