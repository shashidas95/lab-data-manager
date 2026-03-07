<template>
  <div class="relative flex items-center justify-between md:justify-start">
    <div :class="[isComplete ? 'bg-white shadow-lg ring-4 ring-slate-50' : 'bg-slate-100']"
         class="flex items-center justify-center w-10 h-10 rounded-full z-10 transition-all duration-500">
      <i :class="[icon, isComplete ? color : 'text-slate-300']" class="text-sm"></i>
    </div>

    <div class="ml-6">
      <h4 :class="[isComplete ? 'text-slate-900' : 'text-slate-400']" class="font-black text-sm tracking-tight leading-none">
        {{ title }}
      </h4>
      <p v-if="description" class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1">{{ description }}</p>
      <p v-if="date" class="text-[10px] text-blue-600 font-black mt-1">{{ formatDate(date) }}</p>
    </div>

    <span v-if="isActive" class="absolute -left-1 flex h-12 w-12">
      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-20"></span>
    </span>
  </div>
</template>

<script setup>
defineProps(['title', 'description', 'date', 'icon', 'isComplete', 'isActive', 'color']);
const formatDate = (d) => d === 'Active Now' ? d : new Date(d).toLocaleString([], { dateStyle: 'medium', timeStyle: 'short' });
</script>
