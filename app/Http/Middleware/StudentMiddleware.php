<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role->name !== 'Student') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Student.');
        }

        return $next($request);
    }
}
