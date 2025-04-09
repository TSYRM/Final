<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log request details
        Log::info('Request Details', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'params' => $request->all(),
            'headers' => $request->header(),
        ]);
        
        // Process the request
        $response = $next($request);
        
        // Log response status
        Log::info('Response Status', [
            'status' => $response->getStatusCode()
        ]);
        
        return $response;
    }
}
