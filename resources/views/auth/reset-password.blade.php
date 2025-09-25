@extends('layouts.guest')

@section('title', 'إعادة تعيين كلمة المرور')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-blue-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <!-- الشعار -->
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="شعار المنصة" class="mx-auto w-24 h-24">
            <h1 class="text-2xl font-bold text-gray-800 mt-2">منصة المساعدات الإنسانية</h1>
            <p class="text-gray-600">إعادة تعيين كلمة المرور الخاصة بك</p>
        </div>

        <!-- إشعارات النجاح والخطأ -->
        @if (session('status'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                ✅ {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>❌ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- الفورم -->
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- توكن إعادة التعيين -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- البريد الإلكتروني -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-300 focus:border-blue-500">
            </div>

            <!-- كلمة المرور الجديدة -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور الجديدة</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-300 focus:border-blue-500">
            </div>

            <!-- تأكيد كلمة المرور -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">تأكيد كلمة المرور</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-blue-300 focus:border-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                إعادة تعيين كلمة المرور
            </button>
        </form>
    </div>
</div>
@endsection
