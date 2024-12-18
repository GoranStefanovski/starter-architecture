<script lang="ts" setup>
  import { IconIncomingbox } from "@starter-core/icons";
  import { useAuth } from "@websanova/vue-auth/src/v3.js";
  import { computed } from "vue";
  import { DashLink } from "@starter-core/dash-ui/src";

  const auth = useAuth();

  const isUserAllowedToCreate = computed(() =>
    auth.user().permissions_array.includes("write_vacation_days"),
  );
</script>
<template>
  <DashLink
    v-if="isUserAllowedToCreate"
    :to="{ name: 'add.vacationDay' }"
    :icon="IconIncomingbox"
    theme="secondary"
  >
    {{ $t("admin.vacationDays.add") }}
  </DashLink>
</template>
