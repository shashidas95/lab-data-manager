<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
    <div class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden">
      <div class="p-8 bg-slate-50 border-b border-gray-100 flex justify-between items-center">
        <div>
          <h2 class="text-2xl font-black text-slate-800">{{ sample.sample_number }}</h2>
          <p class="text-[10px] text-gray-400 font-mono tracking-tighter uppercase">ID: {{ sample.id }}</p>
        </div>
        <button @click="$emit('close')" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-200 transition">
          <i class="fas fa-times text-gray-400"></i>
        </button>
      </div>

      <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="flex flex-col items-center justify-center border-r border-dashed border-gray-200 pr-8">
          <div class="p-3 bg-white border-2 border-slate-100 rounded-2xl shadow-sm">
            <qrcode-vue
              :value="sample.id"
              :size="120"
              level="H"
              render-as="svg"
              class="rounded-lg"
            />
          </div>
          <p class="mt-4 text-[9px] font-black text-slate-400 uppercase tracking-widest text-center">
            Scan to Verify<br/>Sample Integrity
          </p>
        </div>

        <div class="md:col-span-2 grid grid-cols-2 gap-6">
           <div class="space-y-4">
              <h4 class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Specifications</h4>
              <p class="text-xs font-bold text-slate-700">{{ sample.brand }} - {{ sample.type }}</p>
              <p class="text-xs text-gray-500">{{ sample.flavour }} | {{ sample.color }}</p>
           </div>
           <div class="space-y-4">
              <h4 class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Logistics</h4>
              <p class="text-xs font-bold text-slate-700">Batch: {{ sample.batch_number }}</p>
              <p class="text-xs text-red-500 font-bold">Expires: {{ new Date(sample.expiry_date).toLocaleDateString() }}</p>
           </div>
        </div>
      </div>

      <div class="p-8 bg-white flex justify-end gap-3 border-t border-gray-50">
        <button @click="$emit('close')" class="px-6 py-3 rounded-2xl font-bold text-gray-500 hover:bg-gray-50">Close</button>
        <button @click="printLabel" class="bg-slate-900 text-white px-6 py-3 rounded-2xl font-bold shadow-lg flex items-center gap-2 hover:bg-slate-800">
          <i class="fas fa-print"></i> Print Label
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import QrcodeVue from 'qrcode.vue';

const props = defineProps(['isOpen', 'sample']);
defineEmits(['close']);

const printLabel = () => {
  window.print(); // You can further refine this with a print-specific CSS @media rule
};
</script>
