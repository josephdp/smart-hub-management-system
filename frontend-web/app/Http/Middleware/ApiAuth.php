<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // Jika tidak ada Token API di dalam sesi pengunjung, tendang kembali ke halaman Login
    if (!session()->has('api_token')) {
        return redirect()->route('login');
    }

    return $next($request);
}
}
