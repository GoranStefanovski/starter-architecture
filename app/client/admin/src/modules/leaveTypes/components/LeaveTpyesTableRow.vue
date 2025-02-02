<script setup lang="ts">
  import { IconTrash, IconEdit } from "@starter-core/icons";
  import { useAuth } from "@websanova/vue-auth/src/v3.js";
  import { computed } from "vue";
  import type { GetLeaveTypeResponse } from "../types";

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
      <input
        style="border: none;"
        readonly
          type="color"
          id="colorPicker"
          :value="leaveType.color"
          class="color-input noClick"
        />
    </TableColumn>

    <TableColumn>
      <dash-link
        v-if="auth.user().permissions_array.includes('write_users')"
        :to="{ name: 'edit.leave_type', params: { leaveTypeId: leaveType.id } }"
        theme="primary"
        theme-mod="outline-hover"
        :icon="IconEdit"
      >
        {{ $t("buttons.edit") }}
      </dash-link>
    </TableColumn>

    <TableColumn>
      <DashButton
        v-if="auth.user().permissions_array.includes('delete_users')"
        :icon="IconTrash"
        theme="danger"
        size="sm"
        onclick="deleteLeaveType(leaveType, leaveType.id)"
        is-pill
        is-icon
      />
    </TableColumn>
  </TableRow>
</template>
<style cloped>
.noClick {
    pointer-events: none;
  }
</style>