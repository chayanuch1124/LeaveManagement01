<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsEmployee
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login'); // ถ้าไม่ได้ล็อกอิน ให้กลับไปหน้า Login
        }

        if (Auth::user()->role !== $role) {
            return redirect('/dashboard'); // ถ้าไม่มีสิทธิ์ ให้แสดง Error 403
        }

        return $next($request);
    }
}

