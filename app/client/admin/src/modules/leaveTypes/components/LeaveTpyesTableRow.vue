<script setup lang="ts">
  import { IconTrash, IconEdit } from "@starter-core/icons";
  import { useAuth } from "@websanova/vue-auth/src/v3.js";
  import { computed } from "vue";
  import type { GetLeaveTypeResponse } from "../types";
  import UserRoleBadge from "./UserRoleBadge.vue";
  import UserStatusBadge from "./UserStatusBadge.vue";
  import {
    DashButton,
    DashLink,
    TableColumn,
    TableRow,
  } from "@starter-core/dash-ui/src";

  interface LeaveTypesTableRowProps {
    leaveType: GetLeaveTypeResponse;
    isEvenRow: boolean;
  }

  const { leaveType, isEvenRow } = defineProps<LeaveTypesTableRowProps>();
  const auth = useAuth();
</script>

<template>
  <TableRow :section="'body'" :is-even="isEvenRow">
    <!--kt-datatable__row&#45;&#45;even-->

    <TableColumn>
      {{ leaveType.slug }}
    </TableColumn>

    <TableColumn>
      {{ leaveType.name }}
    </TableColumn>

    <TableColumn>
      <UserStatusBadge :is-paid="leaveType.is_paid" />
    </TableColumn>

    <TableColumn>
      <dash-link
        v-if="auth.user().permissions_array.includes('write_users')"
        :to="{ name: 'edit.leaveType', params: { leaveTpyeId: leaveType.id } }"
        theme="primary"
        theme-mod="outline-hover"
        :icon="IconEdit"
      >
        {{ $t("buttons.edit") }}
      </dash-link>
    </TableColumn>
  </TableRow>
</template>
