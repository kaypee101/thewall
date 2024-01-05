<?php

namespace App\Http\Middleware;

use App\Helpers\LoggingHelper;
use Closure;
use Illuminate\Support\Facades\DB;

class LogDatabaseQueries
{
    public function handle($request, Closure $next)
    {
        DB::enableQueryLog();

        $response = $next($request);

        $queries = DB::getQueryLog();

        $processedQueries = array_map(function ($query) {
            $bindings = $query['bindings'] ?? [];
            foreach ($bindings as $binding) {
                $query['query'] = preg_replace('/\?/', is_numeric($binding) ? $binding : "'$binding'", $query['query'], 1);
            }

            return $query;
        }, $queries);

        $processedQueries = array_values($processedQueries);

        $message = PHP_EOL;
        $level = 'info';
        $channel = 'queries';
        foreach ($processedQueries as $key => $query) {
            $message .= sprintf('%6.2f', $query['time']) . " - " . $query['query'] . PHP_EOL;
        }
        LoggingHelper::logger($message, $level, $channel);

        return $response;
    }
}
