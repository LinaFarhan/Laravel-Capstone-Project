<?php
 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VolunteerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من أن المستخدم مسجل الدخول وأنه متطوع أو مسؤول
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        if (!Auth::user()->isVolunteer() && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'غير مصرح بالوصول إلى هذه الصفحة');
        }

        return $next($request);
    }
}