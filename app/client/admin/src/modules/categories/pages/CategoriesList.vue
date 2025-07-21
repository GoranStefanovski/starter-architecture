<script setup lang="ts">
  import { onMounted } from 'vue';
  import { CategoriesDatatable } from '../components';
  import { PageWrapper } from '@/components';
  import { useRootStore } from '@/store/root';

  const { setBackUrl, setActiveClasses } = useRootStore();

  onMounted(() => {
    setBackUrl('/');
    setActiveClasses({
      main: 'categories',
      sub: 'categories',
      title: 'categories.title',
      hasFilters: 'categories',
    });
  });
</script>
<template>
  <PageWrapper>
    <CategoriesDatatable />
  </PageWrapper>
</template>
