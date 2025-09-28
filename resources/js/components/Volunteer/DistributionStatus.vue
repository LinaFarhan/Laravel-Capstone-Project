<template>
  <div class="bg-yellow-50 p-4 rounded-lg">
    <h3 class="font-semibold mb-3 text-gray-800">🔄 تحديث حالة التسليم</h3>

    <form @submit.prevent="updateStatus" class="space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
          <select v-model="form.delivery_status" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            <option value="assigned">معينة</option>
            <option value="in_progress">قيد التنفيذ</option>
            <option value="delivered">تم التسليم</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">إثبات التسليم (صورة)</label>
          <input type="file" @change="handleFileUpload"
                 class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                 accept="image/*">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">ملاحظات</label>
        <textarea v-model="form.notes" rows="3"
                  class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                  placeholder="أضف أي ملاحظات حول عملية التوزيع..."></textarea>
      </div>

      <div class="flex space-x-3 space-x-reverse">
        <button type="submit" :disabled="loading"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50">
          {{ loading ? 'جاري الحفظ...' : '💾 حفظ التحديثات' }}
        </button>

        <button type="button" @click="$emit('cancel')"
                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
          إلغاء
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive, defineProps, defineEmits } from 'vue'

const props = defineProps({
  distribution: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['updated', 'cancel'])

const loading = ref(false)
const form = reactive({
  delivery_status: props.distribution.delivery_status,
  notes: props.distribution.notes,
  proof_file: null
})

const handleFileUpload = (event) => {
  form.proof_file = event.target.files[0]
}

const updateStatus = async () => {
  loading.value = true

  try {
    const formData = new FormData()
    formData.append('delivery_status', form.delivery_status)
    formData.append('notes', form.notes)
    if (form.proof_file) {
      formData.append('proof_file', form.proof_file)
    }

    const response = await fetch(`/volunteer/distributions/${props.distribution.id}/status`, {
  method: 'PUT', // Route يستخدم PUT
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    })

    if (response.ok) {
      emit('updated')
    }
  } catch (error) {
    console.error('Error updating distribution:', error)
  } finally {
    loading.value = false
  }
}
</script>
