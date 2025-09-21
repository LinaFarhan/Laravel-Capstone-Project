@extends('layouts.app')

@section('title', 'لوحة تحكم المتطوع')
@section('subtitle', 'نظرة عامة على مهامك وإحصائياتك')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="stat-card bg-white p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <span class="text-2xl">📦</span>
                </div>
                <div class="mr-4">
                    <h3 class="text-gray-600 text-sm">إجمالي المهام</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_assignments'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <span class="text-2xl">✅</span>
                </div>
                <div class="mr-4">
                    <h3 class="text-gray-600 text-sm">مكتملة</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['completed_deliveries'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <span class="text-2xl">⏳</span>
                </div>
                <div class="mr-4">
                    <h3 class="text-gray-600 text-sm">قيد التنفيذ</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_deliveries'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Distributions -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold mb-4">📦 آخر المهام الموكلة</h3>
        <div class="space-y-4">
            @forelse($recentDistributions as $distribution)
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div class="flex-1">
                    <h4 class="font-semibold">{{ $distribution->beneficiary->name }}</h4>
                    <p class="text-sm text-gray-600">{{ $distribution->donation->type }} - {{ $distribution->donation->quantity }} وحدة</p>
                    <p class="text-sm text-gray-500">{{ $distribution->beneficiary->address }}</p>
                </div>
                <div class="text-center">
                    <span class="px-3 py-1 rounded-full text-xs 
                        {{ $distribution->delivery_status === 'delivered' ? 'bg-green-100 text-green-800' : 
                           ($distribution->delivery_status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                        {{ $distribution->delivery_status }}
                    </span>
                    <a href="{{ route('volunteer.distributions.show', $distribution) }}" 
                       class="block mt-2 text-blue-600 hover:text-blue-900 text-sm">عرض التفاصيل</a>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-center py-4">لا توجد مهام موكلة</p>
            @endforelse
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold mb-4">⚡ إجراءات سريعة</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('volunteer.distributions.index') }}" class="btn-humanitarian text-center py-3 px-4">
                <span class="block text-xl">📋</span>
                <span>عرض جميع المهام</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="btn-humanitarian text-center py-3 px-4">
                <span class="block text-xl">👤</span>
                <span>تعديل الملف الشخصي</span>
            </a>
        </div>
    </div>
</div>
@endsection