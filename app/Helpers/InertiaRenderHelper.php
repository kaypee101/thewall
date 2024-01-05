<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class InertiaRenderHelper
{
    public static function render(
        string $page,
        array $props = [],
    ) {
        return Inertia::render($page, $props);
    }

    public static function redirect(
        string $redirectUrl = null,
        array $message = [],
    ) {
        //\Log::channel('debug')->debug('AppInertiaResponse.redirect()');
        if (count($message) != 0) {
            $message['id'] = self::randomId();
        }
        return redirect(!empty($redirectUrl) ? $redirectUrl : url()->previous())->with(
            [
                'message' => $message,
            ]
        );
    }

    public static function apiRedirect(
        string $redirectUrl = null,
        array $props = [],
        string $message = null
    ): JsonResponse {
        $response = [
            'redirectUrl' => $redirectUrl,
            'props' => $props,
            'message' => $message,
        ];
        return response()->json($response);
    }

    public static function randomId()
    {
        $md5Hash = md5((string)time());
        return substr($md5Hash, 0, 5);
    }
}
