<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsEmployee
{
    public function handle(Request $request, Closure $next)
    {
        // ตรวจสอบว่าผู้ใช้ล็อกอินแล้ว
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please log in to access this page.');
        }

        // ตรวจสอบว่าผู้ใช้มีบทบาทเป็น 'employee'
        if ($request->user()->role !== 'employee') {
            return redirect('/dashboard');
        }

        // ผ่านการตรวจสอบ ให้ไปยังหน้าถัดไป
        return $next($request);
    }
}
