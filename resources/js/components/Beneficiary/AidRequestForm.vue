<template>
  <div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">📝 طلب مساعدة جديد</h2>
    
    <form @submit.prevent="submitForm" class="space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">نوع المساعدة *</label>
          <select v-model="form.type" required 
                  class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <option value="">اختر نوع المساعدة</option>
            <option value="food">طعام</option>
            <option value="clothing">ملابس</option>
            <option value="medical">مساعدات طبية</option>
            <option value="financial">مساعدات مالية</option>
            <option value="other">أخرى</option>
          </select>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">المستندات (اختياري)</label>
          <input type="file" @change="handleFileUpload" 
                 class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                 accept=".pdf,.jpg,.png">
          <p class="mt-1 text-sm text-gray-500">PDF, JPG, PNG - الحد الأقصى 2MB</p>
        </div>
      </div>
      
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">وصف الطلب *</label>
        <textarea v-model="form.description" required rows="5"
                  class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                  placeholder="صف احتياجاتك بالتفصيل..."></textarea>
      </div>
      
      <div class="flex space-x-4 space-x-reverse">
        <button type="submit" :disabled="loading" 
                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">
          {{ loading ? 'جاري الإرسال...' : '📤 إرسال الطلب' }}
        </button>
        
        <button type="button" @click="$emit('cancel')" 
                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
          ↩ رجوع
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref, defineEmits } from 'vue'

const emit = defineEmits(['submitted', 'cancel'])
const loading = ref(false)

const form = reactive({
  type: '',
  description: '',
  document: null
})

const handleFileUpload = (event) => {
  form.document = event.target.files[0]
}

const submitForm = async () => {
  loading.value = true
  
  try {
    const formData = new FormData()
    formData.append('type', form.type)
    formData.append('description', form.description)
    if (form.document) {
      formData.append('document', form.document)
    }
    
    const response = await fetch('/api/beneficiary/aid-requests', {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    })
    
    if (response.ok) {
      emit('submitted')
    }
  } catch (error) {
    console.error('Error submitting aid request:', error)
  } finally {
    loading.value = false
  }
}
</script>