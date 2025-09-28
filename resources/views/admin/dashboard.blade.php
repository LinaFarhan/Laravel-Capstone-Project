@extends('layouts.app')

@section('title', 'لوحة تحكم المسؤول')
@section('subtitle', 'نظرة عامة على المنصة والإحصائيات')

@section('content')
<div id="app" class="space-y-6">
    <stats-dashboard></stats-dashboard>
    <recent-activities></recent-activities>
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat-card bg-white p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <span class="text-2xl">👥</span>
                </div>
                <div class="mr-4">
                    <h3 class="text-gray-600 text-sm">إجمالي المستخدمين</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <span class="text-2xl">🎁</span>
                </div>
                <div class="mr-4">
                    <h3 class="text-gray-600 text-sm">التبرعات المستلمة</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_donations'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-lg">
                    <span class="text-2xl">📋</span>
                </div>
                <div class="mr-4">
                    <h3 class="text-gray-600 text-sm">طلبات pending</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_requests'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <span class="text-2xl">🚚</span>
                </div>
                <div class="mr-4">
                    <h3 class="text-gray-600 text-sm">التوزيعات المكتملة</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['completed_distributions'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Requests -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4 flex items-center">
                <span class="ml-2">📨 طلبات المساعدة الحديثة</span>
            </h3>
            <div class="space-y-3">
                @forelse($recentRequests as $request)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium">{{ $request->beneficiary->name }}</p>
                        <p class="text-sm text-gray-600">{{ $request->type }} - {{ $request->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs
                        {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                           ($request->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                        {{ $request->status }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">لا توجد طلبات حديثة</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4 flex items-center">
                <span class="ml-2">🎁 التبرعات الحديثة</span>
            </h3>
            <div class="space-y-3">
                @forelse($recentDonations as $donation)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium">{{ $donation->donor_name }}</p>
                        <p class="text-sm text-gray-600">{{ $donation->type }} - {{ $donation->quantity }} وحدة</p>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs
                        {{ $donation->status === 'received' ? 'bg-green-100 text-green-800' :
                           ($donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ $donation->status }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">لا توجد تبرعات حديثة</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold mb-4">⚡ إجراءات سريعة</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.users.create') }}" class="btn-humanitarian text-center py-3 px-4">
                <span class="block text-xl">➕</span>
                <span>مستخدم جديد</span>
            </a>
            <a href="{{ route('admin.donations.create') }}" class="btn-humanitarian text-center py-3 px-4">
                <span class="block text-xl">🎁</span>
                <span>تبرع جديد</span>
            </a>
            <a href="{{ route('admin.aid-requests.index') }}" class="btn-humanitarian text-center py-3 px-4">
                <span class="block text-xl">📋</span>
                <span>مراجعة الطلبات</span>
            </a>
            <a href="{{ route('admin.distributions.create') }}" class="btn-humanitarian text-center py-3 px-4">
                <span class="block text-xl">🚚</span>
                <span>توزيع جديد</span>
            </a>
        </div>
    </div>
</div>
@endsection
