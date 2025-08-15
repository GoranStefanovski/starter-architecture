<script setup lang="ts">
  import { computed, onMounted } from 'vue';
  import { POST_SLOTS_DATATABLE_COLUMNS } from '../constants';
  import PostSlotsTableHeader from './PostSlotsTableHeader.vue';
  import PostSlotTableRow from './PostSlotTableRow.vue';
  import { usePostsTable } from '@/modules/post-slots/composables';
  import { useDatatable, DatatableComponent, DatatableHeader, PaginationComponent } from '@starter-core/dash-ui/src';

  const { query, onPaginationChange } = useDatatable();

  const { data, isLoading, isFetching, error } = usePostsTable(query);

  const pagination = computed(() => data.value?.pagination ?? null);
  const post_slots = computed(() => data.value ?? null);
  onMounted(() => {
    if (!post_slots.value) {
      console.error('No post slots data available');
    }
  });
</script>
<template>
  <DatatableComponent
    :query="query"
    :isLoading="isLoading || isFetching"
    :columns="POST_SLOTS_DATATABLE_COLUMNS"
    :error="error?.message"
  >
    <template #header>
      <DatatableHeader title="Post Slots (by ID in HTML)">
        <PostSlotsTableHeader />
      </DatatableHeader>
    </template>
    <template v-if="post_slots" #default>
      <PostSlotTableRow
        v-for="(post_slot, index) in post_slots"
        :key="post_slot.id"
        :columns="POST_SLOTS_DATATABLE_COLUMNS"
        :post_slot="post_slot"
        :is-even-row="index % 2 === 0"
      />
    </template>
    <template v-if="pagination" #pagination>
      <PaginationComponent :pagination="pagination" :isLoading="isLoading" @change="onPaginationChange" />
    </template>
  </DatatableComponent>
</template>
