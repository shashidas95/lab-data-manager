<template>
  <div class="min-h-screen bg-gray-100 p-8 print:bg-white print:p-0">
    <div class="max-w-4xl mx-auto mb-6 flex justify-between items-center print:hidden">
      <router-link :to="`/samples/${route.params.id}/results`" class="text-blue-600">← Back to Results</router-link>
      <button @click="printPage" class="bg-slate-800 text-white px-6 py-2 rounded shadow hover:bg-slate-900">
        Print Certificate
      </button>
    </div>

    <div id="certificate" class="max-w-4xl mx-auto bg-white shadow-lg p-12 border border-gray-200 print:shadow-none print:border-none">

      <div class="flex justify-between items-start border-b-2 border-slate-800 pb-6 mb-8">
        <div>
          <h1 class="text-3xl font-serif font-bold text-slate-800 tracking-tight">CERTIFICATE OF ANALYSIS</h1>
          <p class="text-sm text-gray-500 mt-1">ISO/IEC 17025 Accredited Laboratory</p>
        </div>
        <div class="text-right">
          <div class="font-bold text-lg">{{ sample?.lab?.name }}</div>
          <p class="text-xs text-gray-500">{{ sample?.lab?.office?.location }}</p>
          <p class="text-xs text-gray-500">{{ sample?.lab?.office?.contact_email }}</p>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-8 mb-10 text-sm">
        <div class="space-y-2">
          <div class="flex justify-between border-b pb-1"><span class="font-bold">Sample ID:</span> <span>{{ sample?.sample_number }}</span></div>
          <div class="flex justify-between border-b pb-1"><span class="font-bold">Product:</span> <span>{{ sample?.product?.name }}</span></div>
          <div class="flex justify-between border-b pb-1"><span class="font-bold">Manufacturer:</span> <span>{{ sample?.product?.manufacturer?.name }}</span></div>
        </div>
        <div class="space-y-2">
          <div class="flex justify-between border-b pb-1"><span class="font-bold">Batch No:</span> <span>{{ sample?.batch_number }}</span></div>
          <div class="flex justify-between border-b pb-1"><span class="font-bold">Date Received:</span> <span>{{ formatDate(sample?.received_at) }}</span></div>
          <div class="flex justify-between border-b pb-1"><span class="font-bold">Report Date:</span> <span>{{ formatDate(new Date()) }}</span></div>
        </div>
      </div>

      <table class="w-full mb-12 border-collapse">
        <thead>
          <tr class="bg-slate-100 text-left text-xs uppercase tracking-widest border-y-2 border-slate-800">
            <th class="py-3 px-2">Parameter</th>
            <th class="py-3 px-2">Method / SOP</th>
            <th class="py-3 px-2">Result</th>
            <th class="py-3 px-2 text-right">Unit</th>
          </tr>
        </thead>
        <tbody class="text-sm">
          <tr v-for="result in sample?.test_results" :key="result.id" class="border-b">
            <td class="py-4 px-2 font-medium">{{ result.parameter?.name }}</td>
            <td class="py-4 px-2 text-gray-500 italic">SOP-{{ result.parameter?.code }}</td>
            <td class="py-4 px-2 font-bold">{{ result.value }}</td>
            <td class="py-4 px-2 text-right text-gray-600">{{ result.parameter?.unit?.symbol }}</td>
          </tr>
        </tbody>
      </table>

      <div class="mt-20 grid grid-cols-2 gap-20">
        <div class="text-center border-t border-gray-400 pt-2">
          <p class="text-xs font-bold uppercase">Laboratory Analyst</p>
        </div>
        <div class="text-center border-t border-gray-400 pt-2">
          <p class="text-xs font-bold uppercase">Quality Assurance Manager</p>
        </div>
      </div>

      <div class="mt-12 text-[10px] text-gray-400 text-center italic">
        This certificate shall not be reproduced except in full, without written approval of the laboratory.
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const sample = ref(null);

onMounted(async () => {
  // Ensure your Laravel SampleController@show loads: 'product.manufacturer', 'lab.office', 'test_results.parameter.unit'
  const res = await axios.get(`/samples/${route.params.id}`);
  sample.value = res.data;
});

const formatDate = (date) => {
  if (!date) return 'N/A';
  return new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
};

const printPage = () => {
  window.print();
};
</script>

<style scoped>
@media print {
  /* Hide everything except the certificate container */
  body * {
    visibility: hidden;
  }
  #certificate, #certificate * {
    visibility: visible;
  }
  #certificate {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }
}
</style>
