@extends('layouts.app')

@section('title', 'تفاصيل طلب المساعدة')
@section('subtitle', 'عرض حالة طلب المساعدة وتفاصيله')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📋 تفاصيل طلب المساعدة</h2>
        <span class="px-4 py-2 rounded-full text-sm 
            {{ $aidRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
               ($aidRequest->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
            {{ $aidRequest->status }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Request Details -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold mb-3">📝 معلومات الطلب</h3>
            <p><strong>نوع المساعدة:</strong> 
                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                    {{ $aidRequest->type }}
                </span>
            </p>
            <p><strong>حالة الطلب:</strong> 
                <span class="px-2 py-1 rounded-full text-sm 
                    {{ $aidRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                       ($aidRequest->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                    {{ $aidRequest->status }}
                </span>
            </p>
            <p><strong>تاريخ الإنشاء:</strong> {{ $aidRequest->created_at->format('Y-m-d H:i') }}</p>
            <p><strong>آخر تحديث:</strong> {{ $aidRequest->updated_at->format('Y-m-d H:i') }}</p>
        </div>

        <!-- Description -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold mb-3">📄 وصف الطلب</h3>
            <p class="text-gray-700">{{ $aidRequest->description }}</p>
        </div>
    </div>

    <!-- Document -->
    @if($aidRequest->document_url)
    <div class="bg-blue-50 p-4 rounded-lg mb-6">
        <h3 class="font-semibold mb-3">📎 المستند المرفق</h3>
        <a href="{{ asset('storage/' . $aidRequest->document_url) }}" target="_blank" 
           class="text-blue-600 hover:text-blue-900 flex items-center">
            <span class="ml-2">📄 عرض المستند</span>
        </a>
    </div>
    @endif

    <!-- Distributions -->
    @if($aidRequest->distributions->count() > 0)
    <div class="bg-green-50 p-4 rounded-lg mb-6">
        <h3 class="font-semibold mb-3">🚚 معلومات التوزيع</h3>
        @foreach($aidRequest->distributions as $distribution)
        <div class="mb-3 p-3 bg-white rounded-lg">
            <p><strong>المتطوع:</strong> {{ $distribution->volunteer->name }}</p>
            <p><strong>نوع التبرع:</strong> {{ $distribution->donation->type }}</p>
            <p><strong>الكمية:</strong> {{ $distribution->donation->quantity }}</p>
            <p><strong>حالة التسليم:</strong> 
                <span class="px-2 py-1 rounded-full text-xs 
                    {{ $distribution->delivery_status === 'delivered' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $distribution->delivery_status }}
                </span>
            </p>
            @if($distribution->delivery_status === 'delivered')
            <p><strong>تاريخ التسليم:</strong> {{ $distribution->updated_at->format('Y-m-d H:i') }}</p>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <!-- Actions -->
    <div class="flex space-x-4 space-x-reverse">
        @if($aidRequest->status === 'pending')
        <a href="{{ route('beneficiary.aid-requests.edit', $aidRequest) }}" 
           class="btn-humanitarian px-6 py-3">
            ✏ تعديل الطلب
        </a>
        @endif
        <a href="{{ route('beneficiary.aid-requests.index') }}" 
           class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
            ↩ رجوع للقائمة
        </a>
    </div>
</div>

<!-- Status Guide -->
<div class="bg-yellow-50 rounded-lg shadow-sm p-6 mt-6">
    <h3 class="text-lg font-semibold mb-3">ℹ دليل الحالات</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="text-center p-3 bg-yellow-100 rounded-lg">
            <span class="text-2xl">⏳</span>
            <p class="font-semibold">قيد الانتظار</p>
            <p class="text-sm">جاري مراجعة طلبك</p>
        </div>
        <div class="text-center p-3 bg-green-100 rounded-lg">
            <span class="text-2xl">✅</span>
            <p class="font-semibold">موافق عليه</p>
            <p class="text-sm">تمت الموافقة على طلبك</p>
        </div>
        <div class="text-center p-3 bg-red-100 rounded-lg">
            <span class="text-2xl">❌</span>
            <p class="font-semibold">مرفوض</p>
            <p class="text-sm">لم يتم الموافقة على طلبك</p>
        </div>
    </div>
</div>
@endsection