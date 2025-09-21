<template>
  <div class="space-y-4">
    <div v-for="distribution in distributions" :key="distribution.id" 
         class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between">
        <div class="flex-1">
          <h3 class="font-semibold text-lg text-gray-800">{{ distribution.beneficiary.name }}</h3>
          <p class="text-gray-600">{{ distribution.donation.type }} - {{ distribution.donation.quantity }} وحدة</p>
          <p class="text-sm text-gray-500">
            <span class="ml-2">📍 {{ distribution.beneficiary.address }}</span>
            <span class="ml-4">📞 {{ distribution.beneficiary.phone }}</span>
          </p>
        </div>
        <div class="text-center">
          <span class="px-3 py-1 rounded-full text-xs" :class="statusClass(distribution.delivery_status)">
            {{ distribution.delivery_status }}
          </span>
          <div class="mt-2">
            <button @click="viewDetails(distribution)" 
                    class="text-blue-600 hover:text-blue-900 text-sm">
              عرض التفاصيل
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <div v-if="loading" class="text-center py-8">
      <p class="text-gray-500">جاري تحميل المهام...</p>
    </div>
    
    <div v-if="!loading && distributions.length === 0" class="text-center py-8">
      <p class="text-lg text-gray-500">لا توجد مهام موكلة</p>
      <p class="text-sm text-gray-400">سيتم إعلامك عندما تكون هناك مهام جديدة</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, defineEmits } from 'vue'

const distributions = ref([])
const loading = ref(true)
const emit = defineEmits(['view-details'])

const statusClass = (status) => {
  return {
    'assigned': 'bg-blue-100 text-blue-800',
    'in_progress': 'bg-yellow-100 text-yellow-800',
    'delivered': 'bg-green-100 text-green-800',
    'cancelled': 'bg-red-100 text-red-800'
  }[status] || 'bg-gray-100 text-gray-800'
}

const viewDetails = (distribution) => {
  emit('view-details', distribution)
}

onMounted(async () => {
  try {
    const response = await fetch('/api/volunteer/distributions')
    const data = await response.json()
    distributions.value = data
  } catch (error) {
    console.error('Error fetching distributions:', error)
  } finally {
    loading.value = false
  }
})
</script>