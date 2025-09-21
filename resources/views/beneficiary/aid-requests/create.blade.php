@extends('layouts.app')

@section('title', 'طلب مساعدة جديد')
@section('subtitle', 'املأ النموذج لطلب مساعدة جديدة')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">📝 طلب مساعدة جديد</h2>

    <form action="{{ route('beneficiary.aid-requests.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">نوع المساعدة *</label>
                <select name="type" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">اختر نوع المساعدة</option>
                    <option value="food">طعام</option>
                    <option value="clothing">ملابس</option>
                    <option value="medical">مساعدات طبية</option>
                    <option value="financial">مساعدات مالية</option>
                    <option value="other">أخرى</option>
                </select>
                @error('type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Document -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">المستندات (اختياري)</label>
                <input type="file" name="document" 
                       class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       accept=".pdf,.jpg,.png">
                <p class="mt-1 text-sm text-gray-500">PDF, JPG, PNG - الحد الأقصى 2MB</p>
                @error('document')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">وصف الطلب *</label>
            <textarea name="description" required rows="5" 
                      class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                      placeholder="صف احتياجاتك بالتفصيل...">{{ old('description') }}</textarea>
            @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Buttons -->
        <div class="flex space-x-4 space-x-reverse">
            <button type="submit" class="btn-humanitarian px-6 py-3">
                📤 إرسال الطلب
            </button>
            <a href="{{ route('beneficiary.aid-requests.index') }}" 
               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                ↩ رجوع
            </a>
        </div>
    </form>
</div>

<!-- Instructions -->
<div class="bg-blue-50 rounded-lg shadow-sm p-6 mt-6">
    <h3 class="text-lg font-semibold mb-3">💡 معلومات مهمة</h3>
    <ul class="list-disc list-inside space-y-2 text-blue-800">
        <li>جميع الحقول marked with * are required</li>
        <li>سيتم مراجعة طلبك خلال 24-48 ساعة</li>
        <li>سيتم إعلامك عبر البريد الإلكتروني عند تحديث حالة الطلب</li>
        <li>يمكنك تتبع حالة طلبك من خلال لوحة التحكم</li>
    </ul>
</div>
@endsection