 @extends('layouts.app')

@section('title', 'لوحة تحكم المستفيد')
@section('subtitle', 'نظرة عامة على طلباتك وإحصائياتك')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat-card bg-white p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <span class="text-2xl">📨</span>
                </div>
                <div class="mr-4">
                    <h3 class="text-gray-600 text-sm">إجمالي الطلبات</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_requests'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <span class="text-2xl">✅</span>
                </div>
                <div class="mr-4">
                    <h3 class="text-gray-600 text-sm">مقبولة</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['approved_requests'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <span class="text-2xl">⏳</span>
                </div>
                <div class="mr-4">
                    <h3 class="text-gray-600 text-sm">قيد الانتظار</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_requests'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <span class="text-2xl">🎁</span>
                </div>
                <div class="mr-4">
                    <h3 class="text-gray-600 text-sm">تم استلامها</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['received_aid'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Requests -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">📨 آخر طلبات المساعدة</h3>
            <div class="space-y-3">
                @forelse($recentRequests as $request)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium">{{ $request->type }}</p>
                        <p class="text-sm text-gray-600">{{ Str::limit($request->description, 40) }}</p>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs 
                        {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($request->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                        {{ $request->status }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">لا توجد طلبات</p>
                @endforelse
            </div>
            <div class="mt-4">
                <a href="{{ route('beneficiary.aid-requests.index') }}" class="text-blue-600 hover:text-blue-900">
                    عرض جميع الطلبات →
                </a>
            </div>
        </div>

        <!-- Recent Distributions -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">🚚 آخر التوزيعات</h3>
            <div class="space-y-3">
                @forelse($recentDistributions as $distribution)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium">{{ $distribution->donation->type }}</p>
                        <p class="text-sm text-gray-600">بواسطة: {{ $distribution->volunteer->name }}</p>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs 
                        {{ $distribution->delivery_status === 'delivered' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $distribution->delivery_status }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">لا توجد توزيعات</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold mb-4">⚡ إجراءات سريعة</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('beneficiary.aid-requests.create') }}" class="btn-humanitarian text-center py-3 px-4">
                <span class="block text-xl">➕</span>
                <span>طلب مساعدة جديد</span>
            </a>
            <a href="{{ route('beneficiary.aid-requests.index') }}" class="btn-humanitarian text-center py-3 px-4">
                <span class="block text-xl">📋</span>
                <span>عرض طلباتي</span>
            </a>
        </div>
    </div>
</div>
@endsection