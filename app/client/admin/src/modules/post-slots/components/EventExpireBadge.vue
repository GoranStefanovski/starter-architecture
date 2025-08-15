<script setup lang="ts">
  import { BadgeComponent } from '@starter-core/dash-ui/src';

  const { isExpired } = defineProps<{ isExpired: boolean | null | undefined }>();
</script>
<template>
  <span>
    <BadgeComponent :theme="isExpired ? 'danger' : 'success'" is-inline is-pill>
      {{ isExpired ? '--Yes--' : '--No--' }}
    </BadgeComponent>
  </span>
</template>
