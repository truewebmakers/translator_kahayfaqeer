<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class Breadcrumb
{
    public static function generate()
    {
        $segments = collect(request()->segments());
        $breadcrumbs = [];

        $url = '';
        foreach ($segments as $segment) {
            $url .= '/' . $segment;
            $breadcrumbs[] = [
                'url' => $url,
                'title' => ucfirst($segment), // You can customize this for prettier titles
            ];
        }

        return $breadcrumbs;
    }
}
