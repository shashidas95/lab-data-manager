<template>
  <div :class="['bg-white p-6 rounded-3xl shadow-vesper border', isCritical ? 'border-red-100 bg-red-50' : isAmber ? 'border-amber-100 bg-amber-50' : 'border-slate-100']">
    <div class="flex justify-between items-center text-slate-400 text-xs font-semibold mb-2">
      {{ title }}
      <i :class="[icon, 'text-blue-500']"></i>
    </div>
    <div class="flex items-baseline gap-1.5">
      <span class="text-4xl font-bold tracking-tight text-slate-950">{{ value }}</span>
      <span class="text-xs text-slate-500">{{ unit }}</span>
    </div>
    <div :class="['text-xs mt-3 font-semibold flex items-center gap-1.5', trend === 'up' ? 'text-green-600' : 'text-red-600']">
      <i :class="trend === 'up' ? 'fas fa-arrow-up' : 'fas fa-arrow-down'"></i>
      {{ percent }}
      <span class="text-slate-400 font-medium">vs. last month</span>
    </div>
  </div>
</template>
<script setup>defineProps(['title', 'value', 'unit', 'icon', 'trend', 'percent', 'isAmber', 'isCritical'])</script>
