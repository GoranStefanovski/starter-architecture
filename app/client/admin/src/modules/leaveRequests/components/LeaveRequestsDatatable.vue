<script setup lang="ts">
  import axios from "axios";
  import { ref, onMounted, computed } from "vue";
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
  const leaveTypes = ref([]);
  const users = ref([]);

  const pagination = computed(() => data.value?.pagination ?? null);
  const leaveRequests = computed(() => data.value?.data ?? null);

  const fetchLeaveTypes = async () => {
    try {
      const response = await axios.get("/leave_type/all");
      leaveTypes.value = response.data;
    } catch (error) {
      console.error("Error fetching leave types:", error);
    }
  };

  const fetchUsers = async () => {
    try {
      const response = await axios.get("/user/draw");
      users.value = response.data.data;
    } catch (error) {
      console.error("Error fetching managers:", error);
    }
  };


  onMounted(() => {
    fetchLeaveTypes();
    fetchUsers();
  });

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
    <template v-if="leaveRequests && leaveTypes.length > 1" #default>
      <LeaveRequestsTableRow
        v-for="(leaveRequest, index) in leaveRequests"
        :key="leaveRequest.id"
        :columns="LEAVE_REQUESTS_DATATABLE_COLUMNS"
        :leaveRequest="leaveRequest"
        :is-even-row="index % 2 === 0"
        :leaveTypes="leaveTypes"
        :users="users"
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
