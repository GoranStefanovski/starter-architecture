<script setup lang="ts">
  import { computed } from 'vue';
  import { EVENTS_DATATABLE_COLUMNS } from '../constants';
  import PostsTableHeader from './PostsTableHeader.vue';
  import PostsTableRow from './PostsTableRow.vue';
  import { usePostsTable } from '@/modules/posts/composables';
  import {
    useDatatable,
    DatatableComponent,
    DatatableFilters,
    DatatableHeader,
    PaginationComponent,
  } from '@starter-core/dash-ui/src';

  const { query, onPaginationChange } = useDatatable();

  const { data, isLoading, isFetching, error } = usePostsTable(query);

  const pagination = computed(() => data.value?.pagination ?? null);
  const posts = computed(() => data.value?.data ?? null);
</script>
<template>
  <DatatableComponent
    :query="query"
    :isLoading="isLoading || isFetching"
    :columns="EVENTS_DATATABLE_COLUMNS"
    :error="error?.message"
  >
    <template #header>
      <DatatableHeader title="Posts" subtitle="List of posts">
        <PostsTableHeader />
      </DatatableHeader>
      <DatatableFilters />
    </template>
    <template v-if="posts" #default>
      <PostsTableRow
        v-for="(post, index) in posts"
        :key="post.id"
        :columns="EVENTS_DATATABLE_COLUMNS"
        :post="post"
        :is-even-row="index % 2 === 0"
      />
    </template>
    <template v-if="pagination" #pagination>
      <PaginationComponent :pagination="pagination" :isLoading="isLoading" @change="onPaginationChange" />
    </template>
  </DatatableComponent>
</template>
