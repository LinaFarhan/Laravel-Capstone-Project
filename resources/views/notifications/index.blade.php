@extends('layouts.app')

@section('title', 'الإشعارات')
@section('subtitle', 'إدارة الإشعارات والتنبيهات')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">🔔 الإشعارات</h2>
        
        <div class="flex space-x-3 space-x-reverse">
            <a href="{{ route('notifications.unread') }}" class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg">
                غير المقروءة ({{ auth()->user()->unreadNotifications()->count() }})
            </a>
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-100 text-green-800 rounded-lg">
                     الكل كمقروء
                </button>
            </form>
            <form action="{{ route('notifications.destroy-all') }}" method="POST" 
                  onsubmit="return confirm('هل أنت متأكد من حذف جميع الإشعارات؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-100 text-red-800 rounded-lg">
                    حذف الكل
                </button>
            </form>
        </div>
    </div>

    @if($notifications->count() > 0)
        <div class="space-y-3">
            @foreach($notifications as $notification)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow 
                    {{ is_null($notification->read_at) ? 'bg-blue-50 border-blue-200' : '' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <span class="text-xl mr-3">{{ $getNotificationIcon($notification->type) }}</span>
                                <h3 class="font-semibold text-gray-800">
                                    {{ $notification->data['message'] ?? 'إشعار جديد' }}
                                </h3>
                            </div>
                            
                            <p class="text-gray-600 text-sm mb-2">
                                {{ $notification->data['description'] ?? '' }}
                            </p>
                            
                            <div class="flex items-center text-xs text-gray-500">
                                <span>{{ $notification->created_at->diffForHumans() }}</span>
                                @if(is_null($notification->read_at))
                                    <span class="mx-2">•</span>
                                    <span class="text-blue-600">غير مقروء</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex space-x-2 space-x-reverse">
                            @if(is_null($notification->read_at))
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 text-sm">
                                        كمقروء
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                                  onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                    حذف
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    @if(isset($notification->data['action_url']))
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <a href="{{ $notification->data['action_url'] }}" 
                               class="text-blue-600 hover:text-blue-900 text-sm">
                                عرض التفاصيل →
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📭</div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">لا توجد إشعارات</h3>
            <p class="text-gray-500">سيظهر هنا أي إشعارات جديدة تتلقاها</p>
        </div>
    @endif
</div>

@php
function getNotificationIcon($type) {
    $icons = [
        'App\Notifications\AidRequestApprovedNotification' => '✅',
        'App\Notifications\AidRequestDeniedNotification' => '❌',
        'App\Notifications\DistributionAssignedNotification' => '📦',
        'App\Notifications\DonationReceivedNotification' => '🎁',
        'App\Notifications\NewAidRequestNotification' => '🆕',
    ];
    
    return $icons[$type] ?? '📢';
}
@endphp
@endsection