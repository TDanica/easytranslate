<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff'); // stricter handling of content types 
        $response->headers->set('X-XSS-Protection', '1; mode=block'); // prevents XSS by blocking
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains'); // enforces https communication
        // $response->headers->set('Content-Security-Policy', "default-src 'self'"); // load resources only form own domain 

        return $response;;
    }
}
