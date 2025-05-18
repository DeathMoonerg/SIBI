<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProgressAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!in_array(auth()->user()->role, ['teacher', 'parent', 'admin'])) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
} 