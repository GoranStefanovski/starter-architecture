<script lang="ts" setup>
  import { useI18n } from "vue-i18n";
  import { FormDropdown } from "@starter-core/dash-ui/src";

  const { t } = useI18n();
  
  const countryOptions = [
    { id: 1, label: "Macedonia", value: "Macedonia", name: 'Macedonia' },
    { id: 2, label: "Bulgaria", value: "Bulgaria", name: 'Bulgaria' }
  ];

  const country = defineModel("country", { required: true });
</script>
<template>
  <form-dropdown
    v-model="country"
    id="role"
    :options="countryOptions"
    :label="'Country'"
    is-inline
  />
</template>
