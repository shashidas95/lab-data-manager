<template>
  <EntityManager
    title="Offices"
    endpoint="offices"
    :columns="[
      { key: 'name', label: 'Office Name' },
      { key: 'code', label: 'Code' },
      { key: 'location', label: 'Location' },
      { key: 'contact_email', label: 'Email' }
    ]"
    :initialForm="{ name: '', code: '', location: '', contact_email: '' }"
  />
</template>

<script setup>
import EntityManager from '@/components/common/EntityManager.vue';
</script>
