 <template>
  <div class="file-upload">
    <label class="block text-sm font-medium text-gray-700 mb-2">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    
    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors"
         @dragover="dragover" @drop="drop" @click="triggerFileInput">
      <input type="file" ref="fileInput" :accept="accept" :multiple="multiple" 
             @change="handleFileChange" class="hidden">
      
      <div v-if="!files.length" class="space-y-2">
        <span class="text-3xl">📁</span>
        <p class="text-gray-600">اسحب الملفات هنا أو انقر للاختيار</p>
        <p class="text-sm text-gray-400">الحد الأقصى: {{ maxSize }}MB</p>
      </div>
      
      <div v-else class="space-y-2">
        <div v-for="(file, index) in files" :key="index" class="flex items-center justify-between p-2 bg-gray-50 rounded">
          <div class="flex items-center">
            <span class="text-lg mr-2">📄</span>
            <span class="text-sm">{{ file.name }}</span>
            <span class="text-xs text-gray-400 ml-2">({{ formatFileSize(file.size) }})</span>
          </div>
          <button @click.stop="removeFile(index)" class="text-red-500 hover:text-red-700">
            ✕
          </button>
        </div>
      </div>
    </div>
    
    <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  label: String,
  required: Boolean,
  accept: {
    type: String,
    default: '/'
  },
  multiple: Boolean,
  maxSize: {
    type: Number,
    default: 2
  },
  modelValue: [File, Array]
})

const emit = defineEmits(['update:modelValue'])

const fileInput = ref(null)
const files = ref([])
const error = ref('')

const triggerFileInput = () => {
  fileInput.value.click()
}

const handleFileChange = (event) => {
  processFiles(Array.from(event.target.files))
}

const dragover = (event) => {
  event.preventDefault()
  event.currentTarget.classList.add('border-blue-500')
}

const drop = (event) => {
  event.preventDefault()
  event.currentTarget.classList.remove('border-blue-500')
  processFiles(Array.from(event.dataTransfer.files))
}

const processFiles = (newFiles) => {
  error.value = ''
  
  const validFiles = newFiles.filter(file => {
    if (file.size > props.maxSize * 1024 * 1024) {
      error.value = الحد الأقصى لحجم الملف هو ${props.maxSize}MB
      return false
    }
    return true
  })
  
  if (props.multiple) {
    files.value = [...files.value, ...validFiles]
  } else {
    files.value = validFiles.slice(0, 1)
  }
  
  emitUpdate()
}

const removeFile = (index) => {
  files.value.splice(index, 1)
  emitUpdate()
}

const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const emitUpdate = () => {
  if (props.multiple) {
    emit('update:modelValue', files.value)
  } else {
    emit('update:modelValue', files.value[0] || null)
  }
}

watch(() => props.modelValue, (newValue) => {
  if (!newValue) {
    files.value = []
  }
})
</script>

<style scoped>
.file-upload {
  cursor: pointer;
}
</style>