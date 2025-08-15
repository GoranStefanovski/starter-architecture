<script setup lang="ts">
  import { onMounted } from 'vue';
  import { PostsDatatable } from '../components';
  import { PageWrapper } from '@/components';
  import { useRootStore } from '@/store/root';

  const { setBackUrl, setActiveClasses } = useRootStore();

  onMounted(() => {
    setBackUrl('/');
    setActiveClasses({
      main: 'posts',
      sub: 'posts',
      title: 'posts.title',
      hasFilters: 'posts',
    });
  });
</script>
<template>
  <PageWrapper>
    <PostsDatatable />
  </PageWrapper>
</template>
