 @extends('layouts.app')

@section('title', 'المهام الموكلة')
@section('subtitle', 'عرض جميع المهام الموكلة إليك')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📦 المهام الموكلة</h2>
        <div class="flex space-x-2 space-x-reverse">
            <a href="?status=assigned" class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg">📋 معينة</a>
            <a href="?status=in_progress" class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg">⏳ قيد التنفيذ</a>
            <a href="?status=delivered" class="px-4 py-2 bg-green-100 text-green-800 rounded-lg">✅ مكتملة</a>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($distributions as $distribution)
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h3 class="font-semibold text-lg">{{ $distribution->beneficiary->name }}</h3>
                    <p class="text-gray-600">{{ $distribution->donation->type }} - {{ $distribution->donation->quantity }} وحدة</p>
                    <p class="text-sm text-gray-500">
                        <span class="ml-2">📍 {{ $distribution->beneficiary->address }}</span>
                        <span class="ml-4">📞 {{ $distribution->beneficiary->phone }}</span>
                    </p>
                </div>
                <div class="text-center">
                    <span class="px-3 py-1 rounded-full text-xs 
                        {{ $distribution->delivery_status === 'delivered' ? 'bg-green-100 text-green-800' : 
                           ($distribution->delivery_status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                        {{ $distribution->delivery_status }}
                    </span>
                    <div class="mt-2">
                        <a href="{{ route('volunteer.distributions.show', $distribution) }}" 
                           class="text-blue-600 hover:text-blue-900 text-sm">عرض التفاصيل</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            <p class="text-lg">لا توجد مهام موكلة</p>
            <p class="text-sm">سيتم إعلامك عندما تكون هناك مهام جديدة</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $distributions->links() }}
    </div>
</div>
@endsection