<template>
  <router-link :to="to" v-bind="$attrs"
    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group"
    active-class="bg-blue-50 text-blue-600 font-bold shadow-sm shadow-blue-50/50">
    <i :class="[icon, 'w-5 text-center transition-colors group-hover:text-blue-500']"></i>
    <span class="text-sm tracking-tight">{{ label }}</span>
  </router-link>
</template>

<script setup>
defineProps(['to', 'icon', 'label']);
</script>
