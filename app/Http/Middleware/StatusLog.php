<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class StatusLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::channel('status')->info($request);
        return $next($request);
    }
    public function terminate(Request $request, Response $response)
    {
        if ($response->original) {
            Log::channel('status')->alert($response->original);
        }
    }
}
