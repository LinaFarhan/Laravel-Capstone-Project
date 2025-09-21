<template>
  <div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-800">📋 تاريخ الطلبات</h2>
      
      <div class="flex space-x-2 space-x-reverse">
        <button @click="filterRequests('all')" 
                :class="['px-3 py-1 rounded-lg text-sm', filter === 'all' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600']">
          الكل
        </button>
        <button @click="filterRequests('pending')" 
                :class="['px-3 py-1 rounded-lg text-sm', filter === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600']">
          ⏳ قيد الانتظار
        </button>
        <button @click="filterRequests('approved')" 
                :class="['px-3 py-1 rounded-lg text-sm', filter === 'approved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600']">
          ✅ مقبولة
        </button>
        <button @click="filterRequests('denied')" 
                :class="['px-3 py-1 rounded-lg text-sm', filter === 'denied' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600']">
          ❌ مرفوضة
        </button>
      </div>
    </div>
    
    <div class="space-y-4">
      <div v-for="request in filteredRequests" :key="request.id" 
           class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
          <div class="flex-1">
            <h3 class="font-semibold text-lg text-gray-800">{{ request.type }}</h3>
            <p class="text-gray-600">{{ request.description }}</p>
            <p class="text-sm text-gray-500">{{ new Date(request.created_at).toLocaleDateString('ar-EG') }}</p>
          </div>
          
          <div class="text-center">
            <span class="px-3 py-1 rounded-full text-xs" :class="statusClass(request.status)">
              {{ request.status }}
            </span>
            
            <div class="mt-2 space-x-2">
              <button @click="viewRequest(request)" 
                      class="text-blue-600 hover:text-blue-900 text-sm">
                عرض
              </button>
              
              <button v-if="request.status === 'pending'" @click="editRequest(request)" 
                      class="text-green-600 hover:text-green-900 text-sm">
                تعديل
              </button>
            </div>
          </div>
        </div>
      </div>
      
      <div v-if="loading" class="text-center py-8">
        <p class="text-gray-500">جاري تحميل الطلبات...</p>
      </div>
      
      <div v-if="!loading && filteredRequests.length === 0" class="text-center py-8">
        <p class="text-lg text-gray-500">لا توجد طلبات</p>
        <p class="text-sm text-gray-400">يمكنك إنشاء طلب جديد بالضغط على زر "طلب جديد"</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, defineEmits } from 'vue'

const requests = ref([])
const loading = ref(true)
const filter = ref('all')
const emit = defineEmits(['view-request', 'edit-request'])

const filteredRequests = computed(() => {
  if (filter.value === 'all') return requests.value
  return requests.value.filter(request => request.status === filter.value)
})

const statusClass = (status) => {
  return {
    'pending': 'bg-yellow-100 text-yellow-800',
    'approved': 'bg-green-100 text-green-800',
    'denied': 'bg-red-100 text-red-800'
  }[status] || 'bg-gray-100 text-gray-800'
}

const viewRequest = (request) => {
  emit('view-request', request)
}

const editRequest = (request) => {
  emit('edit-request', request)
}

const filterRequests = (status) => {
  filter.value = status
}

onMounted(async () => {
  try {
    const response = await fetch('/api/beneficiary/aid-requests')
    const data = await response.json()
    requests.value = data
  } catch (error) {
    console.error('Error fetching aid requests:', error)
  } finally {
    loading.value = false
  }
})
</script>