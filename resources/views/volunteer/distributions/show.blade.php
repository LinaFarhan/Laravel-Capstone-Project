@extends('layouts.app')

@section('title', 'تفاصيل المهمة')
@section('subtitle', 'عرض وتحديث حالة التوزيع')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📦 تفاصيل المهمة</h2>
        <span class="px-4 py-2 rounded-full text-sm
            {{ $distribution->delivery_status === 'delivered' ? 'bg-green-100 text-green-800' :
               ($distribution->delivery_status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
            {{ $distribution->delivery_status }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Beneficiary Information -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold mb-3">👤 معلومات المستفيد</h3>
            <p><strong>الاسم:</strong> {{ $distribution->beneficiary->name }}</p>
            <p><strong>الهاتف:</strong> {{ $distribution->beneficiary->phone }}</p>
            <p><strong>العنوان:</strong> {{ $distribution->beneficiary->address }}</p>
        </div>

        <!-- Donation Information -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold mb-3">🎁 معلومات التبرع</h3>
            <p><strong>النوع:</strong> {{ $distribution->donation->type }}</p>
            <p><strong>الكمية:</strong> {{ $distribution->donation->quantity }}</p>
            <p><strong>الوصف:</strong> {{ $distribution->donation->description }}</p>
        </div>
    </div>

    <!-- Update Status Form -->
    <div class="bg-yellow-50 p-4 rounded-lg mb-6">
        <h3 class="font-semibold mb-3">🔄 تحديث حالة التسليم</h3>
        <form action="{{ route('volunteer.distributions.update-status', $distribution) }}" method="POST"
              enctype="multipart/form-data">
            @csrf

    

    @if(session('success'))
<script>
    window.dispatchEvent(new CustomEvent('toast', {
        detail: {
            title: 'نجاح',
            message: @json(session('success')),
            type: 'success'
        }
    }));
</script>
@endif


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">الحالة</label>
                    <select name="delivery_status" class="mt-1 block w-full border-gray-300 rounded-lg">
                        <option value="assigned" {{ $distribution->delivery_status === 'assigned' ? 'selected' : '' }}>معينة</option>
                        <option value="in_progress" {{ $distribution->delivery_status === 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                        <option value="delivered" {{ $distribution->delivery_status === 'delivered' ? 'selected' : '' }}>تم التسليم</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">إثبات التسليم (صورة)</label>
                    <input type="file" name="proof_file" class="mt-1 block w-full border-gray-300 rounded-lg">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">ملاحظات</label>
                <textarea name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-lg"
                          placeholder="أضف أي ملاحظات حول عملية التوزيع">{{ $distribution->notes }}</textarea>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn-humanitarian px-4 py-2">
                    💾 حفظ التحديثات
                </button>
            </div>
        </form>
    </div>

    <!-- Distribution History -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="font-semibold mb-3">📋 سجل التحديثات</h3>
        <div class="space-y-2">
            <p><strong>تاريخ الإنشاء:</strong> {{ $distribution->created_at->format('Y-m-d H:i') }}</p>
            <p><strong>آخر تحديث:</strong> {{ $distribution->updated_at->format('Y-m-d H:i') }}</p>
            @if($distribution->proof_file)
            <p><strong>إثبات التسليم:</strong>
                <a href="{{ asset('storage/' . $distribution->proof_file) }}" target="_blank"
                   class="text-blue-600 hover:text-blue-900">عرض الصورة</a>
            </p>
            @endif
        </div>
    </div>
</div>
@endsection



{{-- - عرض معلومات المستفيد والتبرع: واضح ومنظم.
- نموذج تحديث الحالة: يحتوي على الحقول المطلوبة (delivery_status, proof_file, notes) ويرتبط بالدالة updateStatus() في الكنترولر.
- عرض إثبات التسليم بعد رفعه: يظهر الرابط بشكل آمن باستخدام
asset().
 --}}
