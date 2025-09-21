@extends('layouts.app')

@section('title', 'إدارة التوزيعات')
@section('subtitle', 'عرض وإدارة توزيعات المساعدات')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">🚚 إدارة التوزيعات</h2>
        <a href="{{ route('admin.distributions.create') }}" class="btn-humanitarian px-4 py-2">
            ➕ توزيع جديد
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-3 text-right">المتطوع</th>
                    <th class="px-4 py-3 text-right">المستفيد</th>
                    <th class="px-4 py-3 text-right">نوع التبرع</th>
                    <th class="px-4 py-3 text-right">حالة التسليم</th>
                    <th class="px-4 py-3 text-right">التاريخ</th>
                    <th class="px-4 py-3 text-right">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($distributions as $distribution)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $distribution->volunteer->name }}</td>
                    <td class="px-4 py-3">{{ $distribution->beneficiary->name }}</td>
                    <td class="px-4 py-3">{{ $distribution->donation->type }}</td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 rounded-full text-xs 
                            {{ $distribution->delivery_status === 'delivered' ? 'bg-green-100 text-green-800' : 
                               ($distribution->delivery_status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 
                               ($distribution->delivery_status === 'assigned' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                            {{ $distribution->delivery_status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $distribution->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex space-x-2 space-x-reverse">
                            <a href="{{ route('admin.distributions.edit', $distribution) }}" 
                               class="text-blue-600 hover:text-blue-900">✏ تعديل</a>
                            <form action="{{ route('admin.distributions.destroy', $distribution) }}" method="POST"
                                  onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">🗑 حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        لا يوجد توزيعات
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $distributions->links() }}
    </div>
</div>
@endsection