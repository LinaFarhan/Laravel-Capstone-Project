<template>
  <span class="px-3 py-1 rounded-full text-xs font-medium" :class="statusClasses">
    <span v-if="showIcon" class="ml-1">{{ statusIcon }}</span>
    {{ statusText }}
  </span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  status: {
    type: String,
    required: true
  },
  type: {
    type: String,
    default: 'default'
  },
  showIcon: {
    type: Boolean,
    default: true
  }
})

const statusConfig = {
  // Request statuses
  pending: { icon: '⏳', text: 'قيد الانتظار', class: 'bg-yellow-100 text-yellow-800' },
  approved: { icon: '✅', text: 'موافق عليه', class: 'bg-green-100 text-green-800' },
  denied: { icon: '❌', text: 'مرفوض', class: 'bg-red-100 text-red-800' },
  
  // Distribution statuses
  assigned: { icon: '📋', text: 'معينة', class: 'bg-blue-100 text-blue-800' },
  in_progress: { icon: '🚚', text: 'قيد التنفيذ', class: 'bg-yellow-100 text-yellow-800' },
  delivered: { icon: '✅', text: 'تم التسليم', class: 'bg-green-100 text-green-800' },
  cancelled: { icon: '❌', text: 'ملغاة', class: 'bg-red-100 text-red-800' },
  
  // Donation statuses
  received: { icon: '🎁', text: 'تم الاستلام', class: 'bg-green-100 text-green-800' },
  distributed: { icon: '✓', text: 'تم التوزيع', class: 'bg-purple-100 text-purple-800' },
  expired: { icon: '⏰', text: 'منتهية', class: 'bg-gray-100 text-gray-800' },
  
  // User statuses
  active: { icon: '✅', text: 'نشط', class: 'bg-green-100 text-green-800' },
  inactive: { icon: '⏸', text: 'غير نشط', class: 'bg-gray-100 text-gray-800' },
  suspended: { icon: '❌', text: 'موقوف', class: 'bg-red-100 text-red-800' }
}

const statusInfo = computed(() => {
  return statusConfig[props.status] || { 
    icon: '❓', 
    text: props.status, 
    class: 'bg-gray-100 text-gray-800' 
  }
})

const statusIcon = computed(() => statusInfo.value.icon)
const statusText = computed(() => statusInfo.value.text)
const statusClasses = computed(() => statusInfo.value.class)
</script>