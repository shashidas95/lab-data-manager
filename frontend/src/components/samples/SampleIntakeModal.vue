<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
  >
    <div class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden">
      <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-slate-50">
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">
          New <span class="text-blue-600">Sample Intake</span>
        </h2>
        <button @click="$emit('close')" class="text-gray-400 hover:text-gray-600">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <form @submit.prevent="handleSubmit" class="p-8 space-y-6">
        <div class="grid grid-cols-2 gap-6">
          <div class="space-y-1">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-2"
              >Manufacturer</label
            >
            <select
              v-model="form.manufacturer_id"
              required
              class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-blue-100"
            >
              <option v-for="m in manufacturers" :key="m.id" :value="m.id">{{ m.name }}</option>
            </select>
          </div>
          <div class="space-y-1">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-2"
              >Product</label
            >
            <select
              v-model="form.product_id"
              required
              class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-blue-100"
            >
              <option v-for="p in products" :key="p.id" :value="p.id">{{ p.name }}</option>
            </select>
          </div>
          <div class="space-y-1">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-2"
              >Batch Number</label
            >
            <input
              v-model="form.batch_number"
              type="text"
              placeholder="e.g. B-9920"
              class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-blue-100"
            />
          </div>
        </div>

        <div class="grid grid-cols-3 gap-6">
          <div class="space-y-1">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-2"
              >Color</label
            >
            <input
              v-model="form.color"
              type="text"
              class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-blue-100"
            />
          </div>
          <div class="space-y-1">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-2"
              >Quantity</label
            >
            <input
              v-model="form.sample_quantity"
              type="number"
              class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-blue-100"
            />
          </div>
          <div class="space-y-1">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-2"
              >Priority</label
            >
            <select
              v-model="form.priority"
              class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-blue-100"
            >
              <option value="normal">Normal</option>
              <option value="high">High</option>
              <option value="urgent">Urgent</option>
            </select>
          </div>
        </div>

        <div class="flex justify-end gap-3 pt-4">
          <button type="button" @click="$emit('close')" class="px-6 py-3 font-bold text-gray-400">
            Cancel
          </button>
          <button
            type="submit"
            class="bg-blue-600 text-white px-10 py-3 rounded-2xl font-bold shadow-lg shadow-blue-100"
          >
            Register Sample
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps(['isOpen'])
const emit = defineEmits(['close', 'success'])

const products = ref([])
const form = ref({
  product_id: '',
  batch_number: '',
  color: '',
  sample_quantity: 1,
  priority: 'normal',
  status: 'received',
})

onMounted(async () => {
  const res = await axios.get('/products')
  products.value = res.data
})

const handleSubmit = async () => {
  try {
    await axios.post('/samples', form.value)
    emit('success')
    emit('close')
  } catch (err) {
    alert('Error saving sample')
  }
}
</script>
