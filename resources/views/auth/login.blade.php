@extends('layouts.guest')

@section('title', 'تسجيل الدخول - منصة المساعدات الإنسانية')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-humanitarian py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white">🤝</h1>
                <h2 class="mt-4 text-3xl font-bold text-red-500">منصة المساعدات الإنسانية</h2>
                <p class="mt-2 text-gray-700">سجل الدخول إلى حسابك</p>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700">البريد الإلكتروني</label>
                    <input id="email" name="email" type="email" required 
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           placeholder="ادخل بريدك الإلكتروني">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700">كلمة المرور</label>
                    <input id="password" name="password" type="password" required 
                           class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           placeholder="ادخل كلمة المرور">
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember_me" class="mr-2 block text-sm  text-gray-900">تذكرني</label>
                    </div>

                    @if (Route::has('password.request'))
                    <a class="text-sm font-bold text-blue-600 hover:text-blue-500" href="{{ route('password.request') }}">
                        نسيت كلمة المرور؟
                    </a>
                    @endif
                </div>

                <div>
                    <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-humanitarian hover:bg-blue-700 focus:outline-none bg-gray-500 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        تسجيل الدخول
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">أو</span>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        ليس لديك حساب؟ 
                        <a href="{{ route('register.choose') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            سجل الآن
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Security Badge -->
        <div class="text-center">
            <p class="text-xs text-gray-700  font-bold flex items-center justify-center">
                <span class="ml-1">🔒</span>
                نظام آمن ومحمي
            </p>
        </div>
    </div>
</div>
@endsection