<script setup lang="ts">
  import { IconTrash, IconEdit } from "@starter-core/icons";
  import { useAuth } from "@websanova/vue-auth/src/v3.js";
  import { computed } from "vue";
  import type { GetLeaveRequestResponse } from "../types";
  import UserRoleBadge from "./UserRoleBadge.vue";
  import UserStatusBadge from "./UserStatusBadge.vue";
  import {
    DashButton,
    DashLink,
    TableColumn,
    TableRow,
  } from "@starter-core/dash-ui/src";

  interface LeaveRequestsTableRowProps {
    leaveRequest: GetLeaveRequestResponse;
    isEvenRow: boolean;
  }

  const { leaveRequest, isEvenRow } = defineProps<LeaveRequestsTableRowProps>();
  const auth = useAuth();
</script>

<template>
  <TableRow :section="'body'" :is-even="isEvenRow">
    <!--kt-datatable__row&#45;&#45;even-->

    <TableColumn>
      {{ leaveRequest.reason }}
    </TableColumn>

    <TableColumn>
      {{ leaveRequest.start_date }}
    </TableColumn>

    <TableColumn>
      {{ leaveRequest.end_date ? leaveRequest.end_date : 'Single Day' }}
    </TableColumn>

    <TableColumn>
      <dash-link
        v-if="auth.user().permissions_array.includes('write_requests')"
        :to="{ name: 'edit.leave_request', params: { leaveRequestId: leaveRequest.id } }"
        theme="primary"
        theme-mod="outline-hover"
        :icon="IconEdit"
      >
        {{ $t("buttons.edit") }}
      </dash-link>
    </TableColumn>
    <TableColumn>
      <DashButton
        v-if="auth.user().permissions_array.includes('delete_requests')"
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
