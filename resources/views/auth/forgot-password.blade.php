@extends('layouts.guest')

@section('title', 'إعادة تعيين كلمة المرور')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-humanitarian py-12 px-4 sm:px-6 lg:px-8">

    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">
    <h2 class="text-xl font-bold mb-4">نسيت كلمة المرور</h2>

    @if (session('status'))
        <div class="mb-4 text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
            <input id="email" type="email" name="email" required autofocus
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
            إرسال رابط إعادة التعيين
        </button>
    </form>
</div>
@endsection
