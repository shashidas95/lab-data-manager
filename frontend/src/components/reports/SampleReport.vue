<template>
  <div class="fixed inset-y-0 right-0 w-full max-w-2xl bg-white shadow-2xl z-[150] p-10 overflow-y-auto border-l border-slate-200 animate-in slide-in-from-right duration-300">
    <div class="flex justify-between items-center mb-8 no-print">
      <button @click="$emit('close')" class="text-slate-400 hover:text-slate-900 flex items-center gap-2 font-bold text-sm transition-colors">
        <i class="fas fa-arrow-left"></i> Back to List
      </button>
      <button @click="printReport" class="bg-slate-900 text-white px-6 py-2 rounded-xl font-bold text-sm flex items-center gap-2 shadow-lg hover:bg-slate-800 transition-all">
        <i class="fas fa-print"></i> Print Report
      </button>
    </div>

    <div id="printable-report" class="print:p-0">
      <div class="flex justify-between items-start border-b-4 border-slate-900 pb-6 mb-8">
        <div>
          <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">Certificate of Analysis</h1>
          <p class="text-slate-500 font-bold uppercase text-[10px] tracking-widest mt-1">Vesper LIMS • Secure Digital Verification</p>
        </div>
        <div class="text-right">
          <div class="font-black text-xl text-blue-600 tracking-tighter">VESPER</div>
          <div class="text-[10px] text-slate-400 font-medium leading-tight tracking-tight">123 Lab Avenue<br>Dhaka, Bangladesh</div>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-8 mb-10 bg-slate-50 p-6 rounded-3xl border border-slate-100">
        <div class="space-y-4">
          <div v-for="field in leftFields" :key="field.label">
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">{{ field.label }}</p>
            <p class="text-sm font-bold text-slate-700">{{ field.value || 'N/A' }}</p>
          </div>
        </div>
        <div class="space-y-4">
          <div v-for="field in rightFields" :key="field.label">
            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">{{ field.label }}</p>
            <p class="text-sm font-bold text-slate-700">{{ field.value || 'N/A' }}</p>
          </div>
        </div>
      </div>

      <h3 class="font-black text-sm uppercase tracking-widest text-slate-900 mb-4 px-1">Testing Parameters & Results</h3>
      <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden mb-12">
        <table class="w-full text-left border-collapse">
          <thead class="bg-slate-900 text-white">
            <tr>
              <th class="p-4 text-[10px] uppercase font-bold">Parameter</th>
              <th class="p-4 text-[10px] uppercase font-bold">Spec Limit</th>
              <th class="p-4 text-[10px] uppercase font-bold text-right">Result</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr v-for="i in 3" :key="i">
              <td class="p-4 text-sm font-bold text-slate-700 italic">Pending Lab Analysis...</td>
              <td class="p-4 text-sm text-slate-400">--</td>
              <td class="p-4 text-sm text-slate-400 font-mono text-right">N/A</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="mt-12 border-t border-slate-100 pt-10">
        <h3 class="font-black text-sm uppercase tracking-widest text-slate-900 mb-8 px-1 flex items-center gap-3">
          <i class="fas fa-history text-blue-500"></i> Audit Timeline
        </h3>
        <SampleTimeline :sample="sample" />
      </div>

      <div class="mt-20 flex justify-between items-end border-t border-slate-100 pt-10">
        <div class="flex-grow">
          <div class="w-40 border-b-2 border-slate-900 mb-2"></div>
          <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Lab Manager Signature</p>
          <div class="mt-6 text-[9px] text-slate-400 max-w-xs leading-relaxed">
            This document is electronically generated and verified. Altering this record is a violation of laboratory policy.
          </div>
        </div>

        <div class="text-right flex flex-col items-end gap-3">
          <div class="p-2 bg-white border border-slate-100 rounded-xl shadow-sm">
            <qrcode-vue :value="verificationUrl" :size="70" level="H" render-as="svg" />
          </div>
          <div class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">
            Scan to Verify<br>
            ID: <span class="text-slate-900">{{ sample.id?.substring(0,13).toUpperCase() }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import QrcodeVue from 'qrcode.vue'; // Ensure this is installed!
import SampleTimeline from './SampleTimeline.vue';

const props = defineProps(['sample']);

const verificationUrl = computed(() => {
  // Replace with your actual production domain
  return `https://lims.vesper.com/verify/${props.sample.id}`;
});

const formatDate = (date) => date ? new Date(date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : 'N/A';

const printReport = () => window.print();

const leftFields = computed(() => [
  { label: 'Sample Number', value: props.sample.sample_number },
  { label: 'Product Name', value: props.sample.product?.name },
  { label: 'Batch Number', value: props.sample.batch_number },
  { label: 'Manufacturer', value: props.sample.manufacturer?.name }
]);

const rightFields = computed(() => [
  { label: 'Received Date', value: formatDate(props.sample.received_at) },
  { label: 'Expiry Date', value: formatDate(props.sample.expiry_date) },
  { label: 'Priority', value: props.sample.priority },
  { label: 'Current Status', value: props.sample.status }
]);
</script>

<style scoped>
@media print {
  .no-print { display: none !important; }
  .fixed { position: relative !important; width: 100% !important; box-shadow: none !important; border: none !important; padding: 0 !important; }
}
</style>
