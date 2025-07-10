<script lang="ts" setup>
  import { IconAdduser } from '@starter-core/icons';
  import { useAuth } from '@websanova/vue-auth/src/v3.js';
  import { computed } from 'vue';
  import { DashLink } from '@starter-core/dash-ui/src';

  const auth = useAuth();

  const isUserAllowedToCreate = computed(() => auth.user().permissions_array.includes('write_stores'));
</script>
<template>
  <DashLink v-if="isUserAllowedToCreate" :to="{ name: 'add.store' }" :icon="IconAdduser" theme="secondary">
    {{ $t('admin.stores.add') }}
  </DashLink>
</template>
