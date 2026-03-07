<template>
  <tr class="hover:bg-slate-50/80 transition-colors group">
    <td class="py-5 flex items-center gap-4">
      <div :class="['w-10 h-10 rounded-xl flex items-center justify-center font-bold text-xs shadow-sm', isCritical ? 'bg-red-100 text-red-700' : isWarning ? 'bg-amber-100 text-amber-700' : 'bg-blue-50 text-blue-600']">
        {{ name.split(' ').map(n=>n[0]).join('').toUpperCase() }}
      </div>
      <div>
        <div class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ name }}</div>
        <div class="text-xs text-slate-400 font-mono">{{ batch }}</div>
      </div>
    </td>
    <td class="text-slate-700 font-semibold px-4">{{ quantity }}</td>
    <td class="px-4">
      <div class="font-medium text-slate-800 text-sm">{{ lab }}</div>
      <div class="text-[11px] text-slate-400 italic">{{ location }}</div>
    </td>
    <td class="text-right">
      <span :class="['text-[10px] font-bold px-3 py-1.5 rounded-lg border', isCritical ? 'bg-red-50 text-red-700 border-red-100' : isWarning ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-blue-50 text-blue-700 border-blue-100']">
        {{ status }}
      </span>
    </td>
  </tr>
</template>

<script setup>
defineProps(['name', 'batch', 'quantity', 'lab', 'location', 'status', 'isCritical', 'isWarning'])
</script>
