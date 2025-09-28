<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من أن المستخدم مسجل الدخول وأنه مسؤول
        if (!Auth::check()) {
            \Log::warning('محاولة وصول بدون تسجيل دخول الى :',$request->path());
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }
        $user=Auth::user();
        \Log::info('فحص صلاحيات المستخدم ',[
            'user_id'=>$user->id,
            'user_name'=>$user->name,
               'user_role'=>$user->role,
                  '_request_path'=>$request->path(),
                     'isAdmin_result'=>$user->isAdmin(),

        ]);

        if ( !$user->isAdmin()) {
            \Log::warning('محاولة وصول غير مصرح',[
                 'user_id'=>$user->id,
               'user_role'=>$user->role,
                  'expected_role'=> 'admin',
            ]);
            return redirect()->route('dashboard')->with('error', 'غير مصرح بالوصول إلى هذه الصفحة');
        }

        return $next($request);
    }
}
