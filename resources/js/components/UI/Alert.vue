<template>
  <div class="rounded-lg p-4 border-l-4" :class="alertClasses" role="alert">
    <div class="flex items-start">
      <span class="text-xl mr-3" :class="iconColor">{{ icon }}</span>
      <div class="flex-1">
        <h3 v-if="title" class="font-semibold" :class="textColor">{{ title }}</h3>
        <p class="mt-1 text-sm" :class="textColor">
          <slot></slot>
        </p>
      </div>
      <button v-if="dismissible" @click="$emit('dismiss')" 
              class="text-gray-400 hover:text-gray-600">
        ✕
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  type: {
    type: String,
    default: 'info',
    validator: (value) => ['success', 'error', 'warning', 'info'].includes(value)
  },
  title: String,
  dismissible: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['dismiss'])

const alertConfig = {
  success: {
    icon: '✅',
    bg: 'bg-green-50',
    border: 'border-green-500',
    text: 'text-green-800'
  },
  error: {
    icon: '❌',
    bg: 'bg-red-50',
    border: 'border-red-500',
    text: 'text-red-800'
  },
  warning: {
    icon: '⚠',
    bg: 'bg-yellow-50',
    border: 'border-yellow-500',
    text: 'text-yellow-800'
  },
  info: {
    icon: 'ℹ',
    bg: 'bg-blue-50',
    border: 'border-blue-500',
    text: 'text-blue-800'
  }
}

const config = computed(() => alertConfig[props.type] || alertConfig.info)

const alertClasses = computed(() =>' ${config.value.bg} ${config.value.border}')
const iconColor = computed(() => config.value.text)
const textColor = computed(() => config.value.text)
const icon = computed(() => config.value.icon)
</script>