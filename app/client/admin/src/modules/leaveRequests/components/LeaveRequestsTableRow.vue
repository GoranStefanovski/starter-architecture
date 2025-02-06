<script setup lang="ts">
  import { IconTrash, IconEdit } from "@starter-core/icons";
  import { useAuth } from "@websanova/vue-auth/src/v3.js";
  import type { GetLeaveRequestResponse } from "../types";
  import LeaveRequestStatusBadge from "./LeaveRequestStatusBadge.vue";
  import {
    DashButton,
    DashLink,
    TableColumn,
    TableRow,
  } from "@starter-core/dash-ui/src";

  interface LeaveRequestsTableRowProps {
    leaveRequest: GetLeaveRequestResponse;
    isEvenRow: boolean;
    leaveTypes: Array<any[]>;
    users: Array<any[]>;
  }

  const { leaveRequest, isEvenRow, leaveTypes, users } = defineProps<LeaveRequestsTableRowProps>();
  const auth = useAuth();



  const getNameLeaveType = (id: number) => {
    const leaveType = leaveTypes.find((type) => type.id === id);
    return leaveType ? leaveType.name : "Unknown Leave Type";
  };

  const getNameUser = (id: number) => {
    const user = users.find((type) => type.id === id);
    return user ? user.first_name + ' ' + user.last_name : "Unknown User";
  };

</script>

<template>
  <TableRow :section="'body'" :is-even="isEvenRow">
    <!--kt-datatable__row&#45;&#45;even-->

    <TableColumn>
      {{ getNameLeaveType(leaveRequest.leave_type_id) }}
    </TableColumn>

    <TableColumn>
      {{ getNameUser(Math.round(leaveRequest.request_to)) }}
    </TableColumn>

    <TableColumn>
      <LeaveRequestStatusBadge :status="leaveRequest.is_confirmed"/>
    </TableColumn>

    <TableColumn>
      {{ leaveRequest.start_date }}
    </TableColumn>

    <TableColumn>
      {{ leaveRequest.end_date ? leaveRequest.end_date : 'Single Day' }}
    </TableColumn>

    <TableColumn>
      <dash-link
        v-if="auth.user().permissions_array.includes('write_requests') && (leaveRequest.is_confirmed == 0 || leaveRequest.is_confirmed == 1)"
        :to="{ name: 'edit.leave_request', params: { leaveRequestId: leaveRequest.id } }"
        theme="primary"
        theme-mod="outline-hover"
        :icon="IconEdit"
      >
        {{ $t("buttons.edit") }}
      </dash-link>
      <span v-else>
        -
      </span>
    </TableColumn>
    <TableColumn>
      <DashButton
        v-if="auth.user().permissions_array.includes('delete_requests') && (leaveRequest.is_confirmed == 0 || leaveRequest.is_confirmed == 1)"
        :icon="IconTrash"
        theme="danger"
        size="sm"
        onclick="deleteRequest(user, user.id)"
        is-pill
        is-icon
      />
    </TableColumn>
  </TableRow>
</template>
