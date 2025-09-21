@extends('layouts.app')

@section('title', 'إدارة التبرعات')
@section('subtitle', 'عرض وإدارة جميع التبرعات')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">🎁 إدارة التبرعات</h2>
        <a href="{{ route('admin.donations.create') }}" class="btn-humanitarian px-4 py-2">
            ➕ تبرع جديد
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-3 text-right">المتبرع</th>
                    <th class="px-4 py-3 text-right">النوع</th>
                    <th class="px-4 py-3 text-right">الكمية</th>
                    <th class="px-4 py-3 text-right">الحالة</th>
                    <th class="px-4 py-3 text-right">التاريخ</th>
                    <th class="px-4 py-3 text-right">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donations as $donation)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $donation->donor_name }}</td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                            {{ $donation->type }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $donation->quantity }}</td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 rounded-full text-xs
                            {{ $donation->status === 'received' ? 'bg-green-100 text-green-800' :
                               ($donation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ $donation->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $donation->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex space-x-2 space-x-reverse">
                            <a href="{{ route('admin.donations.edit', $donation) }}"
                               class="text-blue-600 hover:text-blue-900">✏ تعديل</a>
                            <form action="{{ route('admin.donations.destroy', $donation) }}" method="POST"
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
                        لا يوجد تبرعات
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $donations->links() }}
    </div>
</div>
@endsection
