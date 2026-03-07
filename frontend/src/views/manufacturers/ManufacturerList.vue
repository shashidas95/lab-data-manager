<!-- <template>
  <div class="space-y-8">
    <div class="flex justify-between items-end">
      <div>
        <h1 class="text-3xl font-black text-slate-800">Manufacturers</h1>
        <p class="text-gray-400 font-medium">Manage supply chain partners and laboratory vendors.</p>
      </div>
      <button @click="openCreateModal" class="bg-slate-900 text-white px-6 py-3 rounded-2xl font-bold shadow-lg hover:bg-slate-800 transition-all">
        + Add Partner
      </button>
    </div>

    <div class="bg-white rounded-[2rem] shadow-vesper border border-gray-50 overflow-hidden">
      <table class="w-full text-left">
        <thead class="bg-gray-50/50">
          <tr class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">
            <th class="px-8 py-4">Company Name</th>
            <th class="px-8 py-4">Location</th>
            <th class="px-8 py-4">Contact Person</th>
            <th class="px-8 py-4">Samples Provided</th>
            <th class="px-8 py-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          <tr v-for="m in manufacturers" :key="m.id" class="hover:bg-gray-50/30 transition-colors">
            <td class="px-8 py-5">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                  {{ m.name.charAt(0) }}
                </div>
                <span class="font-bold text-slate-700">{{ m.name }}</span>
              </div>
            </td>
            <td class="px-8 py-5 text-sm text-gray-500 font-medium">
              {{ m.address || 'Global HQ' }}
            </td>
            <td class="px-8 py-5 text-sm text-slate-600">
              {{ m.contact_email || 'N/A' }}
            </td>
            <td class="px-8 py-5">
              <span class="bg-slate-100 px-3 py-1 rounded-full text-[10px] font-black text-slate-500">
                {{ m.samples_count || 0 }} UNITS
              </span>
            </td>
            <td class="px-8 py-5 text-right space-x-3">
              <button @click="editManufacturer(m)" class="text-slate-400 hover:text-blue-600 transition">
                <i class="fas fa-edit"></i>
              </button>
              <button @click="deleteManufacturer(m.id)" class="text-slate-400 hover:text-red-600 transition">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <ManufacturerFormModal
      :is-open="isModalOpen"
      :edit-data="selectedManufacturer"
      @close="isModalOpen = false"
      @success="fetchManufacturers"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ManufacturerFormModal from './ManufacturerFormModal.vue';

const manufacturers = ref([]);
const isModalOpen = ref(false);
const selectedManufacturer = ref(null);

const fetchManufacturers = async () => {
  const res = await axios.get('/manufacturers');
  manufacturers.value = res.data;
};

const openCreateModal = () => {
  selectedManufacturer.value = null;
  isModalOpen.value = true;
};

const editManufacturer = (m) => {
  selectedManufacturer.value = m;
  isModalOpen.value = true;
};

const deleteManufacturer = async (id) => {
  if (confirm('Delete this manufacturer? Existing samples will remain but the reference will be archived.')) {
    await axios.delete(`/manufacturers/${id}`);
    fetchManufacturers();
  }
};

onMounted(fetchManufacturers);
</script> -->
<template>
  <EntityManager
    title="Manufacturers"
    endpoint="manufacturers"
    :columns="[
      { key: 'name', label: 'Name' },
      { key: 'address', label: 'Address' },
      { key: 'license_number', label: 'License' }
    ]"
    :initialForm="{ name: '', address: '', license_number: '' }"
  />
</template>

<script setup>
import EntityManager from '@/components/common/EntityManager.vue';
</script>
