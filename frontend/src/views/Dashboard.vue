<script setup>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useSampleStore } from '@/stores/sampleStore';
import KpiCard from '../components/KpiCard.vue';
import VesperTaskRow from '@/components/VesperTaskRow.vue';

const sampleStore = useSampleStore();
const router = useRouter();

// Quick navigation links for all facilities
const quickActions = [
  { name: 'Register Sample', icon: 'fas fa-plus-circle', path: '/samples', color: 'bg-blue-600' },
  { name: 'Manage Labs', icon: 'fas fa-building', path: '/labs', color: 'bg-indigo-600' },
  { name: 'Product Catalog', icon: 'fas fa-boxes', path: '/products', color: 'bg-slate-800' },
  { name: 'Manufacturers', icon: 'fas fa-industry', path: '/manufacturers', color: 'bg-emerald-600' },
  { name: 'Parameters', icon: 'fas fa-vials', path: '/parameters', color: 'bg-purple-600' },
  { name: 'Test Methods', icon: 'fas fa-flask', path: '/tests', color: 'bg-rose-600' },
  { name: 'Units of Measure', icon: 'fas fa-balance-scale', path: '/units', color: 'bg-amber-600' },
  { name: 'Offices', icon: 'fas fa-map-marker-alt', path: '/offices', color: 'bg-cyan-600' },
];

onMounted(() => {
  sampleStore.fetchSamples();
});
</script>

<template>
  <div class="p-8 bg-slate-50 min-h-screen">
    <div class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Operational Overview</h1>
        <p class="text-sm text-slate-400 font-medium">Real-time status of Vesper LIMS facilities</p>
      </div>
      <div class="text-right">
        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">System Status</p>
        <p class="text-sm font-bold text-green-500 flex items-center gap-2 justify-end">
          <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> All Systems Online
        </p>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <KpiCard title="Total Samples" :value="sampleStore.totalCount" unit="units" icon="fas fa-vial" trend="up" percent="12%" />
      <KpiCard title="Pending" :value="sampleStore.pendingCount" unit="received" icon="fas fa-clock" trend="down" percent="5%" :isAmber="true" />
      <KpiCard title="In Progress" :value="sampleStore.inProgressCount" unit="testing" icon="fas fa-microscope" trend="up" percent="8%" />
      <KpiCard title="Active Labs" value="1" unit="active" icon="fas fa-building" trend="up" percent="0%" />
    </div>

    <div class="mb-10">
      <h2 class="text-[11px] font-black uppercase text-slate-400 tracking-[0.2em] mb-4 ml-1">Quick Access Facilities</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
        <button
          v-for="action in quickActions"
          :key="action.name"
          @click="router.push(action.path)"
          class="flex flex-col items-center justify-center p-4 bg-white border border-slate-100 rounded-[2rem] hover:shadow-xl hover:shadow-slate-200/50 transition-all group"
        >
          <div :class="action.color" class="w-10 h-10 rounded-xl flex items-center justify-center text-white mb-3 shadow-lg group-hover:scale-110 transition-transform">
            <i :class="action.icon" class="text-sm"></i>
          </div>
          <span class="text-[10px] font-black text-slate-600 uppercase tracking-tighter text-center leading-tight">
            {{ action.name }}
          </span>
        </button>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-black text-slate-900 tracking-tight">Live Sample Feed</h2>
          <router-link to="/samples" class="text-xs font-bold text-blue-600 hover:underline">View All</router-link>
        </div>
        <div class="divide-y divide-slate-50">
          <div v-for="sample in sampleStore.samples.slice(0, 5)" :key="sample.id" class="py-4 flex justify-between items-center group">
            <div class="flex items-center gap-4">
              <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-500 transition-colors">
                <i class="fas fa-flask text-xs"></i>
              </div>
              <div>
                <p class="font-black text-slate-700 tracking-tight">{{ sample.sample_number }}</p>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ sample.batch_number }}</p>
              </div>
            </div>
            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest"
                  :class="sample.status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'">
              {{ sample.status }}
            </span>
          </div>
        </div>
      </div>

      <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
        <h2 class="text-xl font-black text-slate-900 tracking-tight mb-6">Critical Actions</h2>
        <div class="space-y-4">
          <VesperTaskRow
            v-if="sampleStore.pendingCount > 0"
            :task="`Assign ${sampleStore.pendingCount} New Samples`"
            date="Today"
            completed="Pending"
            type="Urgent"
            :isCritical="true"
          />
          <VesperTaskRow task="Batch-594 Quality Audit" date="2026-03-08" completed="Pending" type="Review" :isCritical="true" />
          <VesperTaskRow task="PH-Meter Recalibration" date="2026-03-09" completed="Scheduled" type="Maintenance" :isInfo="true" />
        </div>
      </div>
    </div>
  </div>
</template>
