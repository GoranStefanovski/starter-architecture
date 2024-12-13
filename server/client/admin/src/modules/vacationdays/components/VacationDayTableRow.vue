<script setup lang="ts">
  import { IconTrash, IconEdit } from "@starter-core/icons";
  import { useAuth } from "@websanova/vue-auth/src/v3.js";
  import { computed } from "vue";
  import type { GetVacationDayResponse } from "../types";
  import {
    DashButton,
    DashLink,
    TableColumn,
    TableRow,
  } from "@starter-core/dash-ui/src";

  interface UsersTableRowProps {
    vacationDay: GetVacationDayResponse;
    isEvenRow: boolean;
  }

  const { vacationDay, isEvenRow } = defineProps<UsersTableRowProps>();
  const auth = useAuth();

  const avatarSource = computed(() => {
    return new URL(
      `@/../assets/images/placeholders/avatar-placeholder.jpg`,
      import.meta.url,
    ).href;
  });
</script>

<template>
  <TableRow :section="'body'" :is-even="isEvenRow">
    <!--kt-datatable__row&#45;&#45;even-->

    <TableColumn>
      {{ vacationDay.user_id }}
    </TableColumn>

    <TableColumn>
      {{ vacationDay.day_type_id }}
    </TableColumn>

    <TableColumn>
      {{ vacationDay.date_from }}
    </TableColumn>

    <TableColumn>
      {{ vacationDay.date_to }}
    </TableColumn>

    <TableColumn>
      {{ vacationDay.year }}
    </TableColumn>

    <TableColumn>
      <dash-link
        v-if="auth.user().permissions_array.includes('write_vacation_days')"
        :to="{ name: 'edit.vacationDay', params: { vacationDayId: vacationDay.id } }"
        theme="primary"
        theme-mod="outline-hover"
        :icon="IconEdit"
      >
        {{ $t("buttons.edit") }}
      </dash-link>
    </TableColumn>

    <TableColumn>
      <DashButton
        v-if="auth.user().permissions_array.includes('delete_vacation_days')"
        :icon="IconTrash"
        theme="danger"
        size="sm"
        onclick="deleteUser(vacationDay, vacationDay.id)"
        is-pill
        is-icon
      />
    </TableColumn>
  </TableRow>
</template>
