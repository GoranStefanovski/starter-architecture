<script setup lang="ts">
  import { BadgeComponent } from '@starter-core/dash-ui/src';

  const { isActive } = defineProps<{ isActive: boolean | null | undefined }>();
</script>
<template>
  <span>
    <BadgeComponent :theme="isActive ? 'success' : 'danger'" is-inline is-pill>
      {{ !isActive ? $t('users.status.disabled') : $t('users.status.enabled') }}
    </BadgeComponent>
  </span>
</template>
