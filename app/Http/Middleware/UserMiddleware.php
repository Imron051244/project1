<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->type, ['ผู้ซื้อ', 'ผู้ขาย'])) {
            return $next($request);
        }

        return redirect('/'); // หรือแสดงข้อความผิดพลาดตามที่คุณต้องการ
    }
}
