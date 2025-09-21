<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div v-for="stat in stats" :key="stat.title" class="stat-card bg-white p-6 card-hover">
      <div class="flex items-center">
        <div class="p-3 rounded-lg" :class="stat.bgColor">
          <span class="text-2xl">{{ stat.icon }}</span>
        </div>
        <div class="mr-4">
          <h3 class="text-gray-600 text-sm">{{ stat.title }}</h3>
          <p class="text-2xl font-bold text-gray-800">{{ stat.value }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const stats = ref([
  {
    title: 'إجمالي المستخدمين',
    value: 0,
    icon: '👥',
    bgColor: 'bg-blue-100'
  },
  {
    title: 'التبرعات المستلمة',
    value: 0,
    icon: '🎁',
    bgColor: 'bg-green-100'
  },
  {
    title: 'طلبات pending',
    value: 0,
    icon: '📋',
    bgColor: 'bg-orange-100'
  },
  {
    title: 'التوزيعات المكتملة',
    value: 0,
    icon: '🚚',
    bgColor: 'bg-purple-100'
  }
])

onMounted(async () => {
  try {
    const response = await fetch('/api/admin/stats')
    const data = await response.json()
    
    stats.value[0].value = data.total_users || 0
    stats.value[1].value = data.total_donations || 0
    stats.value[2].value = data.pending_requests || 0
    stats.value[3].value = data.completed_distributions || 0
  } catch (error) {
    console.error('Error fetching stats:', error)
  }
})
</script>