<script setup lang="ts">
  import { onMounted } from 'vue';
  import { EventsDatatable } from '../components';
  import { PageWrapper } from '@/components';
  import { useRootStore } from '@/store/root';

  const { setBackUrl, setActiveClasses } = useRootStore();

  onMounted(() => {
    setBackUrl('/');
    setActiveClasses({
      main: 'events',
      sub: 'events',
      title: 'events.title',
      hasFilters: 'events',
    });
  });
</script>
<template>
  <PageWrapper>
    <EventsDatatable />
  </PageWrapper>
</template>
