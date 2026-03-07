LabList
<template>
  <EntityManager
    title="Laboratory Facilities"
    endpoint="labs"
    :columns="[
      { key: 'name', label: 'Lab Name' },
      { key: 'code', label: 'Code' },
      { key: 'contact_person', label: 'Contact' },
      { key: 'accreditation_status', label: 'Accreditation' }
    ]"
    :initialForm="{ name: '', code: '', contact_person: '', accreditation_status: '', office_id: '' }"
  />
</template>

<script setup>
import EntityManager from '@/components/common/EntityManager.vue';
</script>
