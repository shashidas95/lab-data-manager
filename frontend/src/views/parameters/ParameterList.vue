<template>
  <EntityManager
    title="Testing Parameters"
    endpoint="parameters"
    :columns="[
      { key: 'name', label: 'Parameter' },
      { key: 'code', label: 'Code' },
      { key: 'data_type', label: 'Data Type' },
      { key: 'target_value', label: 'Target' }
    ]"
    :initialForm="{ name: '', code: '', unit_id: '', data_type: 'decimal', target_value: '' }"
  />
</template>

<script setup>
import EntityManager from '@/components/common/EntityManager.vue';
</script>
