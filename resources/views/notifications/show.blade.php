@extends('layouts.app')

@section('title', 'تفاصيل الإشعار')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">🔔 تفاصيل الإشعار</h2>
        
        <div class="flex space-x-3 space-x-reverse">
            <a href="{{ route('notifications.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg">
                رجوع
            </a>
            @if(is_null($notification->read_at))
                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg">
                       كمقروء
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="bg-gray-50 rounded-lg p-6">
        <div class="text-center mb-6">
            <span class="text-5xl">{{ $icon }}</span>
        </div>
        
        <div class="space-y-4">
            <div>
                <h3 class="font-semibold text-gray-700">الرسالة:</h3>
                <p class="text-gray-800 text-lg">{{ $notification->data['message'] ?? 'إشعار جديد' }}</p>
            </div>
            
            @if(isset($notification->data['description']))
            <div>
                <h3 class="font-semibold text-gray-700">التفاصيل:</h3>
                <p class="text-gray-600">{{ $notification->data['description'] }}</p>
            </div>
            @endif
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold text-gray-700">نوع الإشعار:</h3>
                    <p class="text-gray-600">{{ $notification->type }}</p>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-700">الحالة:</h3>
                    <p class="text-gray-600">
                        @if(is_null($notification->read_at))
                            <span class="text-blue-600">غير مقروء</span>
                        @else
                            <span class="text-green-600">مقروء</span>
                        @endif
                    </p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold text-gray-700">تاريخ الإرسال:</h3>
                    <p class="text-gray-600">{{ $notification->created_at->format('Y-m-d H:i') }}</p>
                </div>
                
                @if($notification->read_at)
                <div>
                    <h3 class="font-semibold text-gray-700">تاريخ القراءة:</h3>
                    <p class="text-gray-600">{{ $notification->read_at->format('Y-m-d H:i') }}</p>
                </div>
                @endif
            </div>
        </div>
        
        @if(isset($notification->data['action_url']))
        <div class="mt-6 pt-6 border-t border-gray-200">
            <a href="{{ $notification->data['action_url'] }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                الانتقال إلى الإجراء
                <span class="mr-2">→</span>
            </a>
        </div>
        @endif
    </div>
</div>

@php
$icons = [
    'App\Notifications\AidRequestApprovedNotification' => '✅',
    'App\Notifications\AidRequestDeniedNotification' => '❌',
    'App\Notifications\DistributionAssignedNotification' => '📦',
    'App\Notifications\DonationReceivedNotification' => '🎁',
    'App\Notifications\NewAidRequestNotification' => '🆕',
];

$icon = $icons[$notification->type] ?? '📢';
@endphp
@endsection