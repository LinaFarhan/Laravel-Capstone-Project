@extends('layouts.app')

@section('title', 'طلبات المساعدة')
@section('subtitle', 'عرض وإدارة طلبات المساعدة')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📋 طلبات المساعدة</h2>
        <div class="flex space-x-2 space-x-reverse">
            <a href="?status=pending" class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg">⏳ قيد الانتظار</a>
            <a href="?status=approved" class="px-4 py-2 bg-green-100 text-green-800 rounded-lg">✅ موافق عليها</a>
            <a href="?status=denied" class="px-4 py-2 bg-red-100 text-red-800 rounded-lg">❌ مرفوضة</a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-3 text-right">المستفيد</th>
                    <th class="px-4 py-3 text-right">نوع المساعدة</th>
                    <th class="px-4 py-3 text-right">الوصف</th>
                    <th class="px-4 py-3 text-right">الحالة</th>
                    <th class="px-4 py-3 text-right">التاريخ</th>
                    <th class="px-4 py-3 text-right">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aidRequests as $request)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $request->beneficiary->name }}</td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                            {{ $request->type }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ Str::limit($request->description, 50) }}</td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 rounded-full text-xs
                            {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                               ($request->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                            {{ $request->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $request->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex space-x-2 space-x-reverse">
                            <a href="{{ route('admin.aid-requests.show', $request) }}"
                               class="text-blue-600 hover:text-blue-900">👁 عرض</a>
                            @if($request->status === 'pending')
                            <form action="{{ route('admin.aid-requests.update-status', $request) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="text-green-600 hover:text-green-900">✅ قبول</button>
                            </form>
                            <form action="{{ route('admin.aid-requests.update-status', $request) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="denied">
                                <button type="submit" class="text-red-600 hover:text-red-900">❌ رفض</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        لا يوجد طلبات مساعدة
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $aidRequests->links() }}
    </div>
</div>
@endsection
