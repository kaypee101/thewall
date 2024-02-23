<?php

namespace App\Http\Controllers;

use App\Helpers\InertiaRenderHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SetLocaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function locale(Request $request)
    {
        Session::put('locale', $request->get('locale'));
        $props = [
            'locale' => $request->get('locale')
        ];

        // get previous route name
        // route(app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName()),

        // get previous parameters
        // app('router')->getRoutes()->match(app('request')->create(url()->previous()))->parameters(),
        return InertiaRenderHelper::apiRedirect(
            Redirect::back(),
            $props
        );
    }
}
