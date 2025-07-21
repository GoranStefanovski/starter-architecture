<script setup lang="ts">
  import { computed } from 'vue';
  import { useUsersTable, useUserCheck } from '../composables';
  import { STORES_DATATABLE_COLUMNS } from '../constants';
  import CategoriesTableHeader from './CategoriesTableHeader.vue';
  import CategoriesTableRow from './CategoriesTableRow.vue';
  import {
    useDatatable,
    DatatableComponent,
    DatatableFilters,
    DatatableHeader,
    PaginationComponent,
  } from '@starter-core/dash-ui/src';

  const { query, onPaginationChange } = useDatatable();

  const { data, isLoading, isFetching, error } = useUsersTable(query);

  const pagination = computed(() => data.value?.pagination ?? null);
  const categories = computed(() => data.value?.data ?? null);
</script>
<template>
  <DatatableComponent
    :query="query"
    :isLoading="isLoading || isFetching"
    :columns="STORES_DATATABLE_COLUMNS"
    :error="error?.message"
  >
    <template #header>
      <DatatableHeader title="Categories" subtitle="List of categories">
        <CategoriesTableHeader />
      </DatatableHeader>
    </template>
    <template v-if="categories" #default>
      <CategoriesTableRow
        v-for="(category, index) in categories"
        :key="category.id"
        :columns="STORES_DATATABLE_COLUMNS"
        :category="category"
        :is-even-row="index % 2 === 0"
      />
    </template>
    <template v-if="pagination" #pagination>
      <PaginationComponent :pagination="pagination" :isLoading="isLoading" @change="onPaginationChange" />
    </template>
  </DatatableComponent>
</template>
