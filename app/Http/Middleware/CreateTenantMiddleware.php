<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateTenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user->tenants()->count() == 0 && ! $request->routeIs('tenants', 'tenants.*')) {
            return redirect()->route('tenants')->with('error', 'Please create a tenant first.');
        }

        return $next($request);
    }
}
