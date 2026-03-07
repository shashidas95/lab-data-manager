<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Test Method Catalog</h1>
      <p class="text-sm text-gray-500">Official SOPs and associated parameters</p>
    </div>

    <div class="space-y-4">
      <div v-for="test in tests" :key="test.id" class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
        <div
          @click="toggleExpand(test.id)"
          class="p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition"
        >
          <div class="flex items-center space-x-4">
            <div class="bg-blue-100 text-blue-700 p-3 rounded-lg">
              <span class="font-bold text-xs">{{ test.test_category?.substring(0, 3).toUpperCase() }}</span>
            </div>
            <div>
              <h3 class="font-bold text-gray-900">{{ test.name }}</h3>
              <p class="text-xs text-gray-500 font-mono">{{ test.code }} | {{ test.sop_reference }}</p>
            </div>
          </div>

          <div class="flex items-center space-x-6 text-sm text-gray-600">
            <div class="text-center">
              <span class="block font-semibold">{{ test.estimated_tat_hours }}h</span>
              <span class="text-[10px] uppercase text-gray-400 tracking-tighter">TAT</span>
            </div>
            <div class="text-center">
              <span class="block font-semibold">{{ test.parameters?.length || 0 }}</span>
              <span class="text-[10px] uppercase text-gray-400 tracking-tighter">Params</span>
            </div>
            <span class="transform transition-transform" :class="expandedId === test.id ? 'rotate-180' : ''">
              ▼
            </span>
          </div>
        </div>

        <div v-if="expandedId === test.id" class="bg-gray-50 border-t border-gray-100 p-4">
          <h4 class="text-xs font-bold text-gray-400 uppercase mb-3 tracking-widest">Linked Parameters</h4>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            <div v-for="param in test.parameters" :key="param.id"
              class="bg-white p-3 rounded border border-gray-200 flex items-center justify-between shadow-sm">
              <div>
                <span class="block text-sm font-medium text-gray-700">{{ param.name }}</span>
                <span class="text-xs text-gray-500 font-mono">{{ param.code }}</span>
              </div>
              <div class="text-right">
                <span class="text-xs font-bold text-indigo-600">
                  {{ param.unit?.symbol || 'N/A' }}
                </span>
              </div>
            </div>
          </div>
          <div v-if="!test.parameters?.length" class="text-sm text-gray-400 italic">
            No parameters linked to this test method.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const tests = ref([]);
const expandedId = ref(null);

const fetchTests = async () => {
  try {
    // Fetches Tests with parameters.unit loaded from the Laravel API
    const response = await axios.get('/tests');
    tests.value = response.data;
  } catch (error) {
    console.error('Error fetching catalog:', error);
  }
};

const toggleExpand = (id) => {
  expandedId.value = expandedId.value === id ? null : id;
};

onMounted(fetchTests);
</script>
