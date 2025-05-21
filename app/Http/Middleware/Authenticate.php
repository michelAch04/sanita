<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Redirect CMS users to CMS login
            if ($request->is('cms/*')) {
                return route('admin.login'); // Admin login for CMS
            }

            // Redirect website users (e.g., cart, etc.) to customer login
            return route('customer.signin'); // Customer login for website
        }

        return null;
    }
}
