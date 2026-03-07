<template>
  <div class="min-h-screen bg-slate-50 p-4 md:p-8 flex flex-col items-center">
    <div class="w-full max-w-2xl flex justify-between items-center mb-8">
      <div class="font-black text-xl text-blue-600">VESPER <span class="text-slate-900">LIMS</span></div>
      <div class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
        <i class="fas fa-check-circle"></i> Verified Record
      </div>
    </div>

    <div v-if="error" class="bg-white p-12 rounded-[2.5rem] shadow-xl text-center max-w-md border border-red-100">
      <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">
        <i class="fas fa-exclamation-triangle"></i>
      </div>
      <h2 class="text-2xl font-black text-slate-900 mb-2">Invalid Certificate</h2>
      <p class="text-slate-500 text-sm leading-relaxed mb-8">This record could not be found or has been revoked. Please contact the laboratory for assistance.</p>
      <router-link to="/" class="text-blue-600 font-bold text-sm">Return Home</router-link>
    </div>

    <div v-else-if="sample" class="w-full max-w-2xl bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 overflow-hidden border border-slate-100">
      <div class="bg-slate-900 p-8 text-white flex justify-between items-end">
        <div>
          <h2 class="text-2xl font-black tracking-tight">Report Verification</h2>
          <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">ID: {{ sample.id?.substring(0,13).toUpperCase() }}</p>
        </div>
        <button @click="downloadPDF" :disabled="isDownloading" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white px-5 py-2.5 rounded-xl font-bold text-xs transition-all flex items-center gap-2">
          <i v-if="isDownloading" class="fas fa-spinner fa-spin"></i>
          <i v-else class="fas fa-download"></i>
          {{ isDownloading ? 'Generating...' : 'Download PDF' }}
        </button>
      </div>

      <div class="p-8 md:p-12 space-y-10">
        <div class="grid grid-cols-2 gap-6">
          <div v-for="field in verificationFields" :key="field.label">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ field.label }}</p>
            <p class="text-sm font-bold text-slate-900">{{ field.value || 'N/A' }}</p>
          </div>
        </div>

        <div class="border-t border-slate-100 pt-8">
          <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Final Testing Status</h3>
          <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <div :class="statusColor" class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shadow-lg shadow-current/10">
              <i :class="statusIcon"></i>
            </div>
            <div>
              <p class="text-sm font-black text-slate-900 uppercase tracking-tighter">{{ sample.status }}</p>
              <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Validated on {{ new Date(sample.updated_at).toLocaleDateString() }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="p-20 text-center">
      <i class="fas fa-circle-notch fa-spin text-3xl text-blue-500 mb-4"></i>
      <p class="text-slate-400 font-bold">Verifying Authenticity...</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import html2pdf from 'html2pdf.js'; // Ensure installed: npm install html2pdf.js

const route = useRoute();
const sample = ref(null);
const error = ref(false);
const isDownloading = ref(false);

const fetchVerifiedData = async () => {
  try {
    // Note: This endpoint should be a public API route in Laravel (routes/api.php)
    const res = await axios.get(`/public/verify/${route.params.id}`);
    sample.value = res.data;
  } catch (err) {
    error.value = true;
  }
};

const verificationFields = computed(() => [
  { label: 'Sample ID', value: sample.value?.sample_number },
  { label: 'Batch No.', value: sample.value?.batch_number },
  { label: 'Product', value: sample.value?.product?.name },
  { label: 'Manufacturer', value: sample.value?.manufacturer?.name }
]);

const statusColor = computed(() => sample.value?.status === 'completed' ? 'bg-green-500 text-white' : 'bg-amber-500 text-white');
const statusIcon = computed(() => sample.value?.status === 'completed' ? 'fas fa-check' : 'fas fa-clock');

const downloadPDF = async () => {
  isDownloading.value = true;
  const element = document.querySelector('.max-w-2xl'); // Selecting the card content
  const opt = {
    margin: 1,
    filename: `Vesper_Report_${sample.value.sample_number}.pdf`,
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
  };

  await html2pdf().from(element).set(opt).save();
  isDownloading.value = false;
};

onMounted(fetchVerifiedData);
</script>
