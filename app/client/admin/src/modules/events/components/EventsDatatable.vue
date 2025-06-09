<script setup lang="ts">
  import { computed } from 'vue';
  import { EVENTS_DATATABLE_COLUMNS } from '../constants';
  import EventsTableHeader from './EventsTableHeader.vue';
  import EventsTableRow from './EventsTableRow.vue';
  import { useEventsTable } from '@/modules/events/composables';
  import {
    useDatatable,
    DatatableComponent,
    DatatableFilters,
    DatatableHeader,
    PaginationComponent,
  } from '@starter-core/dash-ui/src';

  const { query, onPaginationChange } = useDatatable();

  const { data, isLoading, isFetching, error } = useEventsTable(query);

  const pagination = computed(() => data.value?.pagination ?? null);
  const events = computed(() => data.value?.data ?? null);
</script>
<template>
  <DatatableComponent
    :query="query"
    :isLoading="isLoading || isFetching"
    :columns="EVENTS_DATATABLE_COLUMNS"
    :error="error?.message"
  >
    <template #header>
      <DatatableHeader title="Events" subtitle="List of events">
        <EventsTableHeader />
      </DatatableHeader>
      <DatatableFilters />
    </template>
    <template v-if="events" #default>
      <EventsTableRow
        v-for="(event, index) in events"
        :key="event.id"
        :columns="EVENTS_DATATABLE_COLUMNS"
        :event="event"
        :is-even-row="index % 2 === 0"
      />
    </template>
    <template v-if="pagination" #pagination>
      <PaginationComponent :pagination="pagination" :isLoading="isLoading" @change="onPaginationChange" />
    </template>
  </DatatableComponent>
</template>
