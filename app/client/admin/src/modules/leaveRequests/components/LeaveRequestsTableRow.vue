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
      {{ leaveRequest.slug }}
    </TableColumn>

    <TableColumn>
      {{ leaveRequest.name }}
    </TableColumn>

    <TableColumn>
      <UserStatusBadge :is-paid="leaveRequest.is_paid" />
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
  </TableRow>
</template>
