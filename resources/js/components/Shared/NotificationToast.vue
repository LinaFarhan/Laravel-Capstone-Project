<template>
  <div class="fixed bottom-4 right-4 z-50 space-y-2">
    <div v-for="(notification, index) in notifications" :key="index"
         class="bg-white rounded-lg shadow-lg border-l-4 p-4 min-w-80 transform transition-all duration-300"
         :class="{
           'border-green-500': notification.type === 'success',
           'border-red-500': notification.type === 'error',
           'border-yellow-500': notification.type === 'warning',
           'border-blue-500': notification.type === 'info'
         }">
      <div class="flex items-start">
        <span class="text-xl mr-3" :class="{
          'text-green-500': notification.type === 'success',
          'text-red-500': notification.type === 'error',
          'text-yellow-500': notification.type === 'warning',
          'text-blue-500': notification.type === 'info'
        }">
          {{ notification.icon }}
        </span>
        <div class="flex-1">
          <h3 class="font-semibold text-gray-800">{{ notification.title }}</h3>
          <p class="text-sm text-gray-600">{{ notification.message }}</p>
          <p class="text-xs text-gray-400 mt-1">{{ notification.time }}</p>
        </div>
        <button @click="removeNotification(index)" class="text-gray-400 hover:text-gray-600">
          ✕
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const notifications = ref([])

const removeNotification = (index) => {
  notifications.value.splice(index, 1)
}

// Listen for new notifications
window.Echo.channel('notifications')
  .listen('NotificationSent', (e) => {
    addNotification(e)
  })

const addNotification = (data) => {
  const notification = {
    title: data.title,
    message: data.message,
    type: data.type,
    icon: getIcon(data.type),
    time: new Date().toLocaleTimeString('ar-EG')
  }
  
  notifications.value.push(notification)
  
  // Auto remove after 5 seconds
  setTimeout(() => {
    const index = notifications.value.indexOf(notification)
    if (index > -1) {
      notifications.value.splice(index, 1)
    }
  }, 5000)
}

const getIcon = (type) => {
  const icons = {
    success: '✅',
    error: '❌',
    warning: '⚠',
    info: 'ℹ'
  }
  return icons[type] || '📢'
}

onMounted(() => {
  // Load initial notifications
  fetch('/api/notifications/unread')
    .then(response => response.json())
    .then(data => {
      data.forEach(notif => {
        addNotification({
          title: 'إشعار',
          message: notif.data.message,
          type: notif.data.type
        })
      })
    })
})
</script>