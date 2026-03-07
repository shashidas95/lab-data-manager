<template>
  <div class="relative">
    <EntityManager
      title="Laboratory Samples"
      endpoint="samples"
      :columns="sampleColumns"
      :initialForm="sampleInitialForm"
      @view-report="handleViewReport"
    />

    <Transition name="slide">
      <SampleReport
        v-if="selectedSample"
        :sample="selectedSample"
        @close="selectedSample = null"
      />
    </Transition>

    <div
      v-if="selectedSample"
      @click="selectedSample = null"
      class="fixed inset-0 bg-slate-900/20 backdrop-blur-sm z-[140]"
    ></div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import EntityManager from '@/components/common/EntityManager.vue';
import SampleReport from '@/components/reports/SampleReport.vue';

const selectedSample = ref(null);

const sampleColumns = [
  { key: 'sample_number', label: 'Sample ID' },
  { key: 'batch_number', label: 'Batch No.' },
  // displayKey allows us to show 'product.name' in the table row
  { key: 'product_id', label: 'Product', type: 'select', endpoint: 'products', displayKey: 'product.name' },
  { key: 'lab_id', label: 'Target Lab', type: 'select', endpoint: 'labs', displayKey: 'lab.name' },
  { key: 'manufacturer_id', label: 'Manufacturer', type: 'select', endpoint: 'manufacturers', displayKey: 'manufacturer.name' },
  { key: 'production_date', label: 'Mfg Date', type: 'date' },
  { key: 'expiry_date', label: 'Expiry Date', type: 'date' },
  { key: 'status', label: 'Status', type: 'badge' },
  { key: 'priority', label: 'Priority', type: 'badge' },
  // These fields are needed for the Edit form but hidden in the table list
  { key: 'brand', label: 'Brand', hidden: true },
  { key: 'variant', label: 'Variant', hidden: true },
  { key: 'collected_amount', label: 'Qty', hidden: true },
];

const sampleInitialForm = {
  sample_number: '',
  batch_number: '',
  product_id: '',
  lab_id: '',
  manufacturer_id: '',
  brand: '',
  variant: '',
  production_date: '',
  expiry_date: '',
  collected_amount: '',
  status: 'received',
  priority: 'normal',
};

const handleViewReport = (sample) => {
  selectedSample.value = sample;
};
</script>
