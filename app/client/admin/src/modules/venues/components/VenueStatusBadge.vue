<script setup lang="ts">
  import { BadgeComponent } from '@starter-core/dash-ui/src';

  const { isActivated } = defineProps<{ isActivated: boolean }>();
</script>
<template>
  <span>
    <BadgeComponent :theme="!isActivated ? 'danger' : 'success'" is-inline is-pill>
      {{ !isActivated ? $t('users.status.disabled') : $t('users.status.enabled') }}
    </BadgeComponent>
  </span>
</template>
