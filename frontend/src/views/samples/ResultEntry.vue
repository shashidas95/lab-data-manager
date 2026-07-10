<template>
  <div class="p-6" v-if="sample">
    <div class="mb-6 flex items-center justify-between">
      <div>
        <router-link to="/samples" class="text-blue-600 text-sm hover:underline">← Back to Queue</router-link>
        <h1 class="text-2xl font-bold text-gray-800">Enter Results: {{ sample.sample_number }}</h1>
        <p class="text-gray-500">{{ sample.product?.name }} | {{ sample.batch_number }}</p>
      </div>
      <span :class="statusClass(sample.status)" class="px-3 py-1 rounded-full text-xs font-bold uppercase">
        {{ sample.status }}
      </span>
    </div>

    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
      <h2 class="text-lg font-semibold mb-4 border-b pb-2">Analysis Parameters</h2>

      <div v-if="loadingParams" class="py-4 text-center">Loading parameters...</div>

      <form v-else @submit.prevent="saveResults" class="space-y-6">
        <div v-for="param in parameters" :key="param.id" class="grid grid-cols-3 items-center gap-4 p-3 border-b border-gray-50 last:border-0">
          <label class="text-sm font-medium text-gray-700">
            {{ param.name }}
            <span class="block text-xs text-gray-400 font-normal">{{ param.code }}</span>
          </label>

          <div class="relative">
            <input
              v-model="results[param.id]"
              type="text"
              class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 p-2 border"
              placeholder="Enter value..."
            />
          </div>

          <div class="text-sm text-gray-500 italic">
            Unit: {{ param.unit?.symbol || '-' }}
          </div>
        </div>

        <div class="flex justify-end mt-8">
          <button
            type="submit"
            :disabled="saving"
            class="bg-green-600 text-white px-6 py-2 rounded-md font-bold hover:bg-green-700 disabled:opacity-50 transition"
          >
            {{ saving ? 'Saving...' : 'Submit Final Results' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const sample = ref(null);
const parameters = ref([]);
const results = ref({});
const saving = ref(false);

onMounted(async () => {
  // 1. Fetch sample details
  const sampleRes = await axios.get(`/samples/${route.params.id}`);
  sample.value = sampleRes.data;

  // 2. In a real LIMS, you'd fetch parameters based on the Test assigned to this sample.
  // For now, let's fetch all parameters to demonstrate the entry form.
  const paramRes = await axios.get('/parameters');
  parameters.value = paramRes.data;
});

const saveResults = async () => {
  saving.value = true;
  try {
    const payload = {
      sample_id: sample.value.id,
      results: Object.keys(results.value).map(id => ({
        parameter_id: id,
        value: results.value[id]
      }))
    };

    await axios.post('/test-results', payload);
    // Update status to completed after saving
    await axios.patch(`/samples/${sample.value.id}`, { status: 'completed' });

    router.push('/samples');
  } catch (err) {
    alert('Error saving results');
  } finally {
    saving.value = false;
  }
};

const statusClass = (status) => {
  return status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800';
};
</script>
