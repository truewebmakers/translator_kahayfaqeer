<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;


function Breadcrumbs()
{
    $segments = Request::segments();
    $breadcrumbs = [];
    $url = '';

    foreach ($segments as $segment) {
        $url .= '/' . $segment;
        $breadcrumbs[] = [
            'title' => ucfirst($segment),
            'url' => $url,
        ];
    }

    return $breadcrumbs;
}
