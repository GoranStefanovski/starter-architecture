<script lang="ts" setup>
  import { useI18n } from 'vue-i18n';
  import { FormDropdown, FormInput } from '@starter-core/dash-ui/src';

  const { t } = useI18n();

  const { errors = {} } = defineProps<{
    errors: any;
  }>();
</script>
<template>
  <div></div>
</template>
