<template>
  <div class="flex h-screen bg-slate-50 overflow-hidden">
    <aside class="w-72 bg-white border-r border-slate-200 flex flex-col shrink-0">
      <div class="p-8 flex items-center gap-3">
        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
          <i class="fas fa-flask text-white"></i>
        </div>
        <span class="text-xl font-black text-slate-800 tracking-tighter">VESPER <span class="text-blue-600">LIMS</span></span>
      </div>

      <nav class="flex-grow px-4 space-y-1 overflow-y-auto">
        <SidebarLink to="/" icon="fas fa-chart-pie" label="Dashboard" />

        <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Inventory</div>
        <SidebarLink to="/products" icon="fas fa-boxes" label="Products" />
        <SidebarLink to="/manufacturers" icon="fas fa-industry" label="Manufacturers" />

        <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Laboratory</div>
        <SidebarLink to="/samples" icon="fas fa-vial" label="Lab Samples" />
        <SidebarLink to="/tests" icon="fas fa-microscope" label="Test Definitions" />
        <SidebarLink to="/parameters" icon="fas fa-list-check" label="Parameters" />

        <div class="pt-4 pb-2 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Setup</div>
        <SidebarLink to="/labs" icon="fas fa-building" label="Lab Facilities" />
        <SidebarLink to="/offices" icon="fas fa-map-marker-alt" label="Offices" />
        <SidebarLink to="/units" icon="fas fa-ruler" label="Measurement Units" />
      </nav>

      <div class="p-6 border-t border-slate-100">
        <SidebarLink to="/scan" icon="fas fa-qrcode" label="Quick Scan" class="bg-slate-900 text-white hover:bg-slate-800" />
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
import SidebarLink from '@/components/SidebarLink.vue';
</script>

<style>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
