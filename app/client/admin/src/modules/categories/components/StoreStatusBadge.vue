<script setup lang="ts">
  import { BadgeComponent } from '@starter-core/dash-ui/src';

  const { isActive } = defineProps<{ isActive: boolean }>();
</script>
<template>
  <span>
    <BadgeComponent :theme="!isActive ? 'danger' : 'success'" is-inline is-pill>
      {{ !isActive ? $t('users.status.disabled') : $t('users.status.enabled') }}
    </BadgeComponent>
  </span>
</template>
