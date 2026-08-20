<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Pastikan role user adalah super_admin
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}