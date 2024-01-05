<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class LoggingHelper
{
    public static function logger(
        string $message,
        string $level = 'info',
        string $channel = 'daily'
    ) {
        Log::channel($channel)->$level($message);
    }
}
