<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');
        // Check if the header exists and starts with "Basic "
        if (!$authHeader || !str_starts_with($authHeader, 'Basic ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Decode the base64 encoded username:password
        $encodedCredentials = substr($authHeader, 6);
        $decoded = base64_decode($encodedCredentials);
        [$username, $password] = explode(':', $decoded, 2);

        $validUsername = env('API_AUTH_USERNAME');
        $validPassword = env('API_AUTH_PASSWORD');

        if ($username !== $validUsername || $password !== $validPassword) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
