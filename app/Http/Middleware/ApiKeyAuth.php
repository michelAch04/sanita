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

        // Set your static username and password here
        $validUsername = 'API';
        $validPassword = 'c1e8b2f7-4a9d-4e2b-9a7e-8f3d2b6a1c5e';

        if ($username !== $validUsername || $password !== $validPassword) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
