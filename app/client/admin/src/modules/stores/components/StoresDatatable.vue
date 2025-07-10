<script setup lang="ts">
  import { computed } from 'vue';
  import { useUsersTable, useUserCheck } from '../composables';
  import { STORES_DATATABLE_COLUMNS } from '../constants';
  import StoresTableHeader from './StoresTableHeader.vue';
  import StoresTableRow from './StoresTableRow.vue';
  import {
    useDatatable,
    DatatableComponent,
    DatatableFilters,
    DatatableHeader,
    PaginationComponent,
  } from '@starter-core/dash-ui/src';
  import { USER_PERMISSIONS } from '@/modules/users/constants';

  const { query, onPaginationChange } = useDatatable();
  const { checkUser } = useUserCheck();

  const { data, isLoading, isFetching, error } = useUsersTable(query);

  const pagination = computed(() => data.value?.pagination ?? null);
  const stores = computed(() => data.value?.data ?? null);
</script>
<template>
  <DatatableComponent
    :query="query"
    :isLoading="isLoading || isFetching"
    :columns="STORES_DATATABLE_COLUMNS"
    :error="error?.message"
  >
    <template #header>
      <DatatableHeader title="Stores" subtitle="List of stores">
        <StoresTableHeader v-if="checkUser('permissions', USER_PERMISSIONS.deleteStore)" />
      </DatatableHeader>
    </template>
    <template v-if="stores" #default>
      <StoresTableRow
        v-for="(store, index) in stores"
        :key="store.id"
        :columns="STORES_DATATABLE_COLUMNS"
        :store="store"
        :is-even-row="index % 2 === 0"
      />
    </template>
    <template v-if="pagination" #pagination>
      <PaginationComponent :pagination="pagination" :isLoading="isLoading" @change="onPaginationChange" />
    </template>
  </DatatableComponent>
</template>
