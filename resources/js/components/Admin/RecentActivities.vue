<template>
  <div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-semibold mb-4 flex items-center">
      <span class="ml-2">📊 النشاطات الحديثة</span>
    </h3>
    
    <div class="space-y-4">
      <div v-for="activity in activities" :key="activity.id" class="flex items-start p-3 bg-gray-50 rounded-lg">
        <span class="text-xl mt-1 mr-3" :class="activity.iconColor">{{ activity.icon }}</span>
        <div class="flex-1">
          <p class="font-medium text-gray-800">{{ activity.title }}</p>
          <p class="text-sm text-gray-600">{{ activity.description }}</p>
          <p class="text-xs text-gray-400 mt-1">{{ activity.time }}</p>
        </div>
      </div>
      
      <div v-if="loading" class="text-center py-4">
        <p class="text-gray-500">جاري تحميل النشاطات...</p>
      </div>
      
      <div v-if="!loading && activities.length === 0" class="text-center py-4">
        <p class="text-gray-500">لا توجد نشاطات حديثة</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const activities = ref([])
const loading = ref(true)

const getIcon = (type) => {
  const icons = {
    user: { icon: '👥', color: 'text-blue-500' },
    donation: { icon: '🎁', color: 'text-green-500' },
    request: { icon: '📋', color: 'text-orange-500' },
    distribution: { icon: '🚚', color: 'text-purple-500' }
  }
  return icons[type] || { icon: '📢', color: 'text-gray-500' }
}

onMounted(async () => {
  try {
    const response = await fetch('/api/admin/activities')
    const data = await response.json()
    
    activities.value = data.map(activity => {
      const iconInfo = getIcon(activity.type)
      return {
        ...activity,
        icon: iconInfo.icon,
        iconColor: iconInfo.color,
        time: new Date(activity.created_at).toLocaleDateString('ar-EG')
      }
    })
  } catch (error) {
    console.error('Error fetching activities:', error)
  } finally {
    loading.value = false
  }
})
</script>