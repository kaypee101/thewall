<?php

namespace App\Helpers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class RouteServiceProviderHelper
{
    public static function home()
    {
        if (Auth::user()->hasRole('admin')) {
            return RouteServiceProvider::ADMIN_HOME;
        }
        return RouteServiceProvider::HOME;
    }
}
