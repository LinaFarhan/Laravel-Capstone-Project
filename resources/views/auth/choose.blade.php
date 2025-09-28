@extends('layouts.guest')

@section('title', 'اختيار نوع الحساب')

@section('content')
<div class=" flex items-center justify-center min-h-screen">
<div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md text-center">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">اختر نوع الحساب</h1>
    <p class="text-red-600 mb-6">من فضلك اختر نوع الحساب الذي تريد إنشاؤه:</p>

    <div class="space-y-4">
        <a href="{{ route('register', ['role' => 'beneficiary']) }}" 
           class="block w-full py-3 bg-gray-500 text-white font-semibold rounded-xl shadow hover:bg-green-600 transition">
            مستفيد
        </a>
        <a href="{{ route('register', ['role' => 'volunteer']) }}" 
           class="block w-full py-3 bg-gray-500 text-white font-semibold rounded-xl shadow hover:bg-blue-600 transition">
            متطوع
        </a>
        <a href="{{ route('register', ['role' => 'admin']) }}" 
           class="block w-full py-3 bg-gray-500 text-white font-semibold rounded-xl shadow hover:bg-red-600 transition">
            مسؤول
        </a>
    </div>
</div>
</div>
@endsection
