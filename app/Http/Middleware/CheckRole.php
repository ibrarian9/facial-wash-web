<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $userRole = Auth::user()->role;

        if ($role == 'admin' && $userRole !== 1) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN ADMIN.');
        }

        if ($role == 'user' && $userRole !== 2) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN USER.');
        }

        return $next($request);
    }
}
