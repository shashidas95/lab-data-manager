<template>
  <EntityManager
    title="Measurement Units"
    endpoint="units"
    :columns="[
      { key: 'name', label: 'Unit Name' },
      { key: 'abbreviation', label: 'Abbr.' },
      { key: 'category', label: 'Category' }
    ]"
    :initialForm="{ name: '', abbreviation: '', category: '' }"
  />
</template>

<script setup>
import EntityManager from '@/components/common/EntityManager.vue';
</script>
