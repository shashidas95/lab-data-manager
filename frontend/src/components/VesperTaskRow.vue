VesperTaskRow
<template>
  <div
    class="flex items-center gap-4 text-xs font-semibold hover:bg-slate-50 p-2 rounded-xl transition"
  >
    <i
      :class="[
        isCritical
          ? 'fas fa-dot-circle text-red-500'
          : isWarning
            ? 'fas fa-dot-circle text-amber-500'
            : isInfo
              ? 'fas fa-dot-circle text-blue-500'
              : 'far fa-circle text-green-500',
      ]"
    ></i>
    <div class="flex-grow">
      <div class="text-slate-950 text-sm font-semibold">{{ task }}</div>
      <div class="text-slate-400 font-medium">Req: {{ date }}</div>
    </div>
    <div class="text-right">
      <div class="text-slate-400 font-medium">{{ completed }}</div>
      <span
        :class="[
          'text-[10px] font-bold px-2.5 py-1 rounded-full',
          isCritical
            ? 'bg-red-100 text-red-800'
            : isWarning
              ? 'bg-amber-100 text-amber-800'
              : 'bg-blue-100 text-blue-800',
        ]"
      >
        {{ type }}
      </span>
    </div>
  </div>
</template>
<script setup>
defineProps(['task', 'date', 'completed', 'type', 'isCritical', 'isWarning', 'isInfo'])
</script>
