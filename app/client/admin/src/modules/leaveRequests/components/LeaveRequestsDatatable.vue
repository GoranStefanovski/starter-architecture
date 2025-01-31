<script setup lang="ts">
  import { computed } from "vue";
  import { useUsersTable } from "../composables";
  import { LEAVE_REQUESTS_DATATABLE_COLUMNS } from "../constants";
  import LeaveRequestsTableHeader from "./LeaveRequestsTableHeader.vue";
  import LeaveRequestsTableRow from "./LeaveRequestsTableRow.vue";
  import {
    useDatatable,
    DatatableComponent,
    DatatableFilters,
    DatatableHeader,
    PaginationComponent,
  } from "@starter-core/dash-ui/src";

  const { query, onPaginationChange } = useDatatable();

  const { data, isLoading, isFetching, error } = useUsersTable(query);

  const pagination = computed(() => data.value?.pagination ?? null);
  const leaveRequests = computed(() => data.value?.data ?? null);
</script>
<template>
  <DatatableComponent
    :query="query"
    :isLoading="isLoading || isFetching"
    :columns="LEAVE_REQUESTS_DATATABLE_COLUMNS"
    :error="error?.message"
  >
    <template #header>
      <DatatableHeader title="Leave Requests">
        <LeaveRequestsTableHeader />
      </DatatableHeader>
      <DatatableFilters />
    </template>
    <template v-if="leaveRequests" #default>
      <LeaveRequestsTableRow
        v-for="(leaveRequest, index) in leaveRequests"
        :key="leaveRequest.id"
        :columns="LEAVE_REQUESTS_DATATABLE_COLUMNS"
        :leaveRequest="leaveRequest"
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
