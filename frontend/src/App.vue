<template>
  <div class="flex h-screen bg-slate-50 overflow-hidden" :class="{ 'h-auto overflow-y-auto': isPublicRoute }">
    <!-- Sidebar Navigation, hidden on public-facing routes like LandingPage -->
    <aside v-if="!isPublicRoute" class="w-72 bg-white border-r border-slate-200 flex flex-col shrink-0">
      <div class="p-8 flex items-center gap-3">
        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
          <i class="fas fa-flask text-white"></i>
        </div>
        <span class="text-xl font-black text-slate-800 tracking-tighter">VESPER <span class="text-blue-600">LIMS</span></span>
      </div>

      <nav class="flex-grow px-4 space-y-1 overflow-y-auto">
        <SidebarLink to="/dashboard" icon="fas fa-chart-pie" label="Dashboard" />
        <SidebarLink to="/company-info" icon="fas fa-id-card" label="Company Info" />

        <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Inventory</div>
        <SidebarLink to="/products" icon="fas fa-boxes" label="Products" />
        <SidebarLink to="/manufacturers" icon="fas fa-industry" label="Manufacturers" />

        <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Laboratory</div>
        <SidebarLink to="/samples" icon="fas fa-vial" label="Lab Samples" />
        <SidebarLink to="/tests" icon="fas fa-microscope" label="Test Definitions" />
        <SidebarLink to="/parameters" icon="fas fa-list-check" label="Parameters" />

        <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">BSTI Chemical & Food</div>
        <SidebarLink to="/food-samples" icon="fas fa-apple-whole" label="BDS Food Samples" />
        <SidebarLink to="/food-verify" icon="fas fa-certificate" label="Verify B-Codes" />

        <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Setup</div>
        <SidebarLink to="/labs" icon="fas fa-building" label="Lab Facilities" />
        <SidebarLink to="/offices" icon="fas fa-map-marker-alt" label="Offices" />
        <SidebarLink to="/units" icon="fas fa-ruler" label="Measurement Units" />
      </nav>

      <div class="p-6 border-t border-slate-100 space-y-4">
        <SidebarLink to="/scan" icon="fas fa-qrcode" label="Quick Scan" class="bg-slate-900 text-white hover:bg-slate-800" />

        <!-- User Profile & Logout -->
        <div v-if="authStore.isAuthenticated && authStore.currentUser" class="pt-4 border-t border-slate-100">
          <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-black text-sm uppercase">
              {{ authStore.currentUser.name ? authStore.currentUser.name.charAt(0) : 'U' }}
            </div>
            <div class="min-w-0 flex-1">
              <p class="text-xs font-black text-slate-800 truncate">{{ authStore.currentUser.name }}</p>
              <p class="text-[10px] font-bold text-slate-400 truncate">{{ authStore.currentUser.email }}</p>
            </div>
          </div>
          <button
            @click="handleLogout"
            class="w-full py-2.5 px-4 rounded-xl text-xs font-black text-rose-600 bg-rose-50 hover:bg-rose-100 transition-all flex items-center justify-center gap-2"
          >
            <i class="fas fa-sign-out-alt"></i> Sign Out
          </button>
        </div>
      </div>
    </aside>

    <main class="flex-grow overflow-y-auto relative">
      <router-view v-slot="{ Component }">
        <transition name="fade" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </main>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import SidebarLink from '@/components/SidebarLink.vue';
import { useAuthStore } from '@/stores/authStore';

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();

const isPublicRoute = computed(() => route.meta && route.meta.public);

const handleLogout = async () => {
  await authStore.logout();
  router.push('/login');
};
</script>

<style>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
