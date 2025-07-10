<script setup lang="ts">
  import { onMounted } from 'vue';
  import { StoresDatatable } from '../components';
  import { PageWrapper } from '@/components';
  import { useRootStore } from '@/store/root';

  const { setBackUrl, setActiveClasses } = useRootStore();

  onMounted(() => {
    setBackUrl('/');
    setActiveClasses({
      main: 'stores',
      sub: 'stores',
      title: 'stores.title',
      hasFilters: 'stores',
    });
  });
</script>
<template>
  <PageWrapper>
    <StoresDatatable />
  </PageWrapper>
</template>
