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
        if (!$request->expectsJson()) {
            // Check which guard is being used
            $guard = $request->route()?->middleware()[0] ?? null;
            
            // If it's pendaftaran guard, redirect to santri login
            if (str_contains($guard, 'pendaftaran')) {
                return route('santri.login');
            }
            
            // Check if the request is for santri routes
            if ($request->is('santri/*')) {
                return route('santri.login');
            }
            
            // Check if the request is for admin routes
            if ($request->is('admin/*')) {
                return route('admin.login');
            }
            
            // Default redirect to home or login
            return route('santri.login');
        }
        
        return null;
    }
}