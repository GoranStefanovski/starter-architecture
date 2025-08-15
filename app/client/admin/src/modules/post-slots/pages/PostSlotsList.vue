<script setup lang="ts">
  import { onMounted } from 'vue';
  import { PostSlotsDatatable } from '../components';
  import { PageWrapper } from '@/components';
  import { useRootStore } from '@/store/root';

  const { setBackUrl, setActiveClasses } = useRootStore();

  onMounted(() => {
    setBackUrl('/');
    setActiveClasses({
      main: 'post-slots',
      sub: 'post-slots',
      title: 'post-slots.title',
      hasFilters: 'post-slots',
    });
  });
</script>
<template>
  <PageWrapper>
    <PostSlotsDatatable />
  </PageWrapper>
</template>
