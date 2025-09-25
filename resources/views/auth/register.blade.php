@extends('layouts.guest')

@section('title', 'تسجيل حساب جديد')

@section('content')
<div class=" flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold mb-6 text-center">إنشاء حساب جديد</h1>

    
    <form id="registerForm" method="POST" action="{{ route('register') }}">
        @csrf

        <!-- الاسم -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">الاسم</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400">
            @error('name')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- البريد الإلكتروني -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">البريد الإلكتروني</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   class="block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400">
            @error('email')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- كلمة المرور -->
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-semibold mb-2">كلمة المرور</label>
            <input id="password" type="password" name="password" required
                   class="block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400">
            <p id="passwordError" class="text-red-500 text-sm mt-2 hidden">
                كلمة المرور يجب أن تكون 8 أحرف على الأقل
            </p>
            @error('password')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- تأكيد كلمة المرور -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">تأكيد كلمة المرور</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="block w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400">
        </div>

        <!-- الحقل المخفي للدور -->
        <input type="hidden" name="role" value="{{ request('role', 'beneficiary') }}">

        <!-- روابط التسجيل والدخول -->
        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">هل لديك حساب؟ تسجيل الدخول</a>
            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                تسجيل
            </button>
        </div>
    </form>
</div>

<script>
const passwordInput = document.getElementById('password');
const passwordError = document.getElementById('passwordError');
const form = document.getElementById('registerForm');

// التحقق أثناء الكتابة
passwordInput.addEventListener('input', function() {
    if (passwordInput.value.length < 8) {
        passwordError.classList.remove('hidden');
    } else {
        passwordError.classList.add('hidden');
    }
});

// التحقق عند الإرسال
form.addEventListener('submit', function(e) {
    if (passwordInput.value.length < 8) {
        e.preventDefault(); // يمنع إرسال الفورم
        passwordError.classList.remove('hidden');
    }
});
</script>
@endsection
