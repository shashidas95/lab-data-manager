<template>
  <div class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">

    <TimelineItem
      title="Sample Received"
      :date="sample.received_at"
      icon="fas fa-inbox"
      :isComplete="true"
      color="text-blue-500"
    />

    <TimelineItem
      title="Assigned to Lab"
      :description="sample.lab?.name || 'Pending Assignment'"
      :date="sample.created_at"
      icon="fas fa-microscope"
      :isComplete="!!sample.lab_id"
      color="text-purple-500"
    />

    <TimelineItem
      title="Testing in Progress"
      description="Analytical parameters being verified"
      :date="sample.status === 'in_progress' ? 'Active Now' : ''"
      icon="fas fa-vials"
      :isComplete="['in_progress', 'completed'].includes(sample.status)"
      :isActive="sample.status === 'in_progress'"
      color="text-amber-500"
    />

    <TimelineItem
      title="Report Validated"
      description="Final CoA generated and signed"
      :date="sample.status === 'completed' ? sample.updated_at : ''"
      icon="fas fa-check-double"
      :isComplete="sample.status === 'completed'"
      color="text-green-500"
    />
  </div>
</template>

<script setup>
import TimelineItem from './TimelineItem.vue';
defineProps(['sample']);
</script>
