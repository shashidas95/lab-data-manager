<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import axios from 'axios'

const props = defineProps({
  title: String,
  endpoint: String,
  columns: Array,
  initialForm: Object,
})

const items = ref([])
const lookupData = ref({})
const searchQuery = ref('')
const loading = ref(false)
const showModal = ref(false)
const editingId = ref(null)
const form = ref({ ...props.initialForm })

// --- 1. DATA FETCHING ---
const fetchItems = async () => {
  loading.value = true
  try {
    const res = await axios.get(`/${props.endpoint}`)
    items.value = Array.isArray(res.data) ? res.data : res.data.data || []
  } catch (err) {
    console.error(`Fetch error:`, err)
  } finally {
    loading.value = false
  }
}

const fetchLookups = async () => {
  const rels = props.columns.filter((col) => col.type === 'select')
  for (const rel of rels) {
    try {
      const res = await axios.get(`/${rel.endpoint}`)
      lookupData.value[rel.key] = Array.isArray(res.data) ? res.data : res.data.data || []
    } catch (err) {
      console.error(`Lookup error for ${rel.endpoint}:`, err)
    }
  }
}

// --- 2. FORMATTING HELPERS ---
const formatDisplayValue = (item, col) => {
  // A. Handle Nested Relationships (e.g., product.name)
  let value = col.displayKey
    ? col.displayKey.split('.').reduce((obj, key) => obj?.[key], item)
    : item[col.key];

  if (value === null || value === undefined) return 'N/A';

  // B. Format Dates to Human Readable (e.g., Mar 07, 2026)
  if (col.type === 'date' || (typeof value === 'string' && value.includes('T') && !isNaN(Date.parse(value)))) {
    return new Date(value).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'short',
      day: '2-digit'
    });
  }

  return value;
};

const getStatusClass = (value) => {
  const val = String(value).toLowerCase();
  if (['completed', 'active', 'high', 'urgent'].includes(val)) return 'bg-green-100 text-green-700';
  if (['pending', 'received', 'normal', 'in_progress'].includes(val)) return 'bg-blue-100 text-blue-700';
  if (['rejected', 'inactive', 'low'].includes(val)) return 'bg-red-100 text-red-700';
  return 'bg-slate-100 text-slate-600';
};

// --- 3. SEARCH & CRUD ---
const filteredItems = computed(() => {
  if (!searchQuery.value) return items.value
  return items.value.filter((item) => {
    return props.columns.some((col) => {
      const val = formatDisplayValue(item, col);
      return String(val).toLowerCase().includes(searchQuery.value.toLowerCase());
    });
  });
})

const openCreate = () => {
  editingId.value = null
  form.value = { ...props.initialForm }
  showModal.value = true
}

const openEdit = (item) => {
  editingId.value = item.id
  const formattedItem = { ...item };
  // Ensure date inputs get YYYY-MM-DD format
  props.columns.forEach(col => {
    if (col.type === 'date' && formattedItem[col.key]) {
      formattedItem[col.key] = formattedItem[col.key].split('T')[0];
    }
  });
  form.value = formattedItem
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  editingId.value = null
}

const handleSubmit = async () => {
  loading.value = true
  try {
    if (editingId.value) {
      await axios.put(`/${props.endpoint}/${editingId.value}`, form.value)
    } else {
      await axios.post(`/${props.endpoint}`, form.value)
    }
    closeModal()
    await fetchItems()
  } catch (err) {
    alert('Save failed: ' + (err.response?.data?.message || 'Check connection'));
  } finally {
    loading.value = false
  }
}

const deleteItem = async (id) => {
  if (!confirm('Permanently delete this record?')) return
  try {
    await axios.delete(`/${props.endpoint}/${id}`)
    await fetchItems()
  } catch (err) {
    console.error('Delete failed:', err)
  }
}

onMounted(() => { fetchItems(); fetchLookups(); })
</script>

<template>
  <div class="p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
      <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ title }}</h1>
        <p class="text-sm text-slate-400 font-medium">Manage and monitor laboratory data</p>
      </div>

      <div class="flex items-center gap-3 w-full md:w-auto">
        <div class="relative flex-grow md:w-64">
          <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
          <input v-model="searchQuery" type="text" placeholder="Search..."
            class="w-full bg-white border border-slate-200 pl-11 pr-4 py-3 rounded-2xl text-sm focus:ring-4 focus:ring-blue-100 transition shadow-sm" />
        </div>
        <button @click="openCreate"
          class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl transition shadow-xl shadow-blue-200 font-bold text-sm flex items-center gap-2">
          <i class="fas fa-plus text-xs"></i> New Entry
        </button>
      </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden">
      <div v-if="loading && !items.length" class="p-20 text-center">
        <i class="fas fa-circle-notch fa-spin text-3xl text-blue-500 mb-4"></i>
        <p class="text-slate-400 font-bold">Synchronizing LIMS...</p>
      </div>

      <div v-else class="overflow-x-auto">
        <table class="w-full text-left">
          <thead class="bg-slate-50/50 border-b border-slate-100">
            <tr>
              <th v-for="col in columns.filter(c => !c.hidden)" :key="col.key"
                class="p-6 text-[10px] uppercase font-black text-slate-400 tracking-widest">
                {{ col.label }}
              </th>
              <th class="p-6 text-right text-[10px] uppercase font-black text-slate-400 tracking-widest">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-50">
            <tr v-for="item in filteredItems" :key="item.id" class="hover:bg-blue-50/30 transition-all group">
              <td v-for="col in columns.filter(c => !c.hidden)" :key="col.key" class="p-6 text-sm font-bold text-slate-700">

                <template v-if="['status', 'priority', 'is_active'].includes(col.key)">
                  <span :class="getStatusClass(item[col.key])" class="px-3 py-1 rounded-full text-[10px] font-black uppercase whitespace-nowrap">
                    {{ item[col.key] }}
                  </span>
                </template>

                <template v-else>
                  {{ formatDisplayValue(item, col) }}
                </template>
              </td>

              <td class="p-6 text-right">
                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                  <button @click="openEdit(item)" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-100 text-blue-500 rounded-xl hover:bg-blue-600 hover:text-white transition-all">
                    <i class="fas fa-edit text-xs"></i>
                  </button>
                  <button @click="deleteItem(item.id)" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-100 text-red-500 rounded-xl hover:bg-red-600 hover:text-white transition-all">
                    <i class="fas fa-trash text-xs"></i>
                  </button>
                  <button v-if="endpoint === 'samples'" @click="$emit('view-report', item)" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-100 text-slate-500 rounded-xl hover:bg-slate-900 hover:text-white transition-all">
                    <i class="fas fa-file-contract text-xs"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div v-if="showModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-md">
      <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
          <h2 class="text-2xl font-black text-slate-900 tracking-tight">{{ editingId ? 'Update' : 'Register' }} {{ title.slice(0, -1) }}</h2>
          <button @click="closeModal" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times text-xl"></i></button>
        </div>
        <form @submit.prevent="handleSubmit" class="p-8 space-y-5 max-h-[70vh] overflow-y-auto">
          <div v-for="col in columns" :key="col.key">
            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">{{ col.label }}</label>
            <select v-if="col.type === 'select'" v-model="form[col.key]" required class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-100 transition outline-none">
              <option value="" disabled>Select {{ col.label }}</option>
              <option v-for="opt in lookupData[col.key]" :key="opt.id" :value="opt.id">{{ opt.name || opt.sample_number }}</option>
            </select>
            <input v-else-if="col.type === 'date'" type="date" v-model="form[col.key]" required class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-100 transition outline-none" />
            <input v-else-if="col.key !== 'id'" v-model="form[col.key]" required class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-100 transition outline-none" />
          </div>
          <div class="flex gap-4 pt-4">
            <button type="button" @click="closeModal" class="flex-1 py-4 text-sm font-bold text-slate-400 transition">Cancel</button>
            <button type="submit" class="flex-1 py-4 bg-slate-900 text-white rounded-2xl font-black shadow-xl hover:bg-blue-600 transition">Save Record</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
