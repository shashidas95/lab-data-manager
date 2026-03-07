<template>
  <EntityManager
    title="Test Definitions"
    endpoint="tests"
    :columns="[
      { key: 'name', label: 'Test Name' },
      { key: 'code', label: 'Code' },
      { key: 'test_category', label: 'Category' },
      { key: 'sop_reference', label: 'SOP Ref' }
    ]"
    :initialForm="{ name: '', code: '', test_category: '', sop_reference: '', estimated_tat_hours: '' }"
  />
</template>

<script setup>
import EntityManager from '@/components/common/EntityManager.vue';
</script>
