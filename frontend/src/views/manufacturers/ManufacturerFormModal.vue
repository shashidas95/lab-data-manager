<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden animate-in zoom-in duration-300">
      <div class="p-8 bg-slate-50 border-b border-gray-100">
        <h2 class="text-2xl font-black text-slate-800">{{ editData ? 'Edit' : 'Add' }} Manufacturer</h2>
      </div>

      <form @submit.prevent="handleSubmit" class="p-8 space-y-5">
        <div class="space-y-1">
          <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-2">Company Name</label>
          <input v-model="form.name" type="text" required class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-blue-100" />
        </div>

        <div class="space-y-1">
          <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-2">Address / HQ</label>
          <input v-model="form.address" type="text" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-blue-100" />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div class="space-y-1">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-2">License No.</label>
            <input v-model="form.license_number" type="text" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-blue-100" />
          </div>
          <div class="space-y-1">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-2">Contact Email</label>
            <input v-model="form.contact_email" type="email" class="w-full px-4 py-3 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-blue-100" />
          </div>
        </div>

        <div class="flex justify-end gap-3 pt-6">
          <button type="button" @click="$emit('close')" class="px-6 py-3 font-bold text-gray-400 hover:text-gray-600 transition">Cancel</button>
          <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-slate-200 hover:bg-slate-800 transition-all">
            {{ editData ? 'Update Partner' : 'Save Manufacturer' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';

const props = defineProps(['isOpen', 'editData']);
const emit = defineEmits(['close', 'success']);

const form = ref({
  name: '',
  address: '',
  license_number: '',
  contact_email: ''
});

// Watch for edit data to populate form
watch(() => props.editData, (newVal) => {
  if (newVal) form.value = { ...newVal };
  else form.value = { name: '', address: '', license_number: '', contact_email: '' };
}, { immediate: true });

const handleSubmit = async () => {
  try {
    if (props.editData) {
      await axios.put(`/manufacturers/${props.editData.id}`, form.value);
    } else {
      await axios.post('/manufacturers', form.value);
    }
    emit('success');
    emit('close');
  } catch (err) {
    alert('Failed to save manufacturer details.');
  }
};
</script>
