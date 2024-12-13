<script setup lang="ts">
  import { computed } from "vue";
  import { useVacationDaysTable } from "../composables";
  import { USERS_DATATABLE_COLUMNS } from "../constants";
  import VacationDayTableHeader from "./VacationDayTableHeader.vue";
  import VacationDayTableRow from "./VacationDayTableRow.vue";
  import {
    useDatatable,
    DatatableComponent,
    DatatableFilters,
    DatatableHeader,
    PaginationComponent,
  } from "@starter-core/dash-ui/src";

  const { query, onPaginationChange } = useDatatable();

  const { data, isLoading, isFetching, error } = useVacationDaysTable(query);

  const pagination = computed(() => data.value?.pagination ?? null);
  const vacationDays = computed(() => data.value?.data ?? null);
</script>
<template>
  <DatatableComponent
    :query="query"
    :isLoading="isLoading || isFetching"
    :columns="USERS_DATATABLE_COLUMNS"
    :error="error?.message"
  >
    <template #header>
      <DatatableHeader title="Vacation Days">
        <VacationDayTableHeader />
      </DatatableHeader>
      <DatatableFilters />
    </template>
    <template v-if="vacationDays" #default>
      <VacationDayTableRow
        v-for="(vacationDay, index) in vacationDays"
        :key="vacationDay.id"
        :columns="USERS_DATATABLE_COLUMNS"
        :user="vacationDay"
        :is-even-row="index % 2 === 0"
      />
    </template>
    <template v-if="pagination" #pagination>
      <PaginationComponent
        :pagination="pagination"
        :isLoading="isLoading"
        @change="onPaginationChange"
      />
    </template>
  </DatatableComponent>
</template>
