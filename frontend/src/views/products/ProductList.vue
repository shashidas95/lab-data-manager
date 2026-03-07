<template>
  <EntityManager
    title="Product Catalog"
    endpoint="products"
    :columns="[
      { key: 'name', label: 'Product Name' },
      { key: 'sku', label: 'SKU' },
      { key: 'category', label: 'Category' }
    ]"
    :initialForm="{ name: '', sku: '', category: '', manufacturer_id: '', description: '' }"
  />
</template>

<script setup>
import EntityManager from '@/components/common/EntityManager.vue';
</script>
