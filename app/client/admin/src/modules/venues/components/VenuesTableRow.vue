<script setup lang="ts">
  import { IconTrash, IconEdit } from '@starter-core/icons';
  import { computed } from 'vue';
  import type { GetUserResponse } from '../types';
  import VenueStatusBadge from './VenueStatusBadge.vue';
  import { useUserCheck } from '@/modules/users/composables';
  import { USER_PERMISSIONS } from '@/modules/users/constants';
  import { DashButton, DashLink, TableColumn, TableRow } from '@starter-core/dash-ui/src';

  interface VenuesTableRowProps {
    user: GetUserResponse;
    isEvenRow: boolean;
  }

  const { checkUser } = useUserCheck();
  const { user, isEvenRow } = defineProps<VenuesTableRowProps>();

  const avatarSource = computed(() => {
    if (user.avatar_thumbnail) {
      return user.avatar_thumbnail;
    }
    return new URL(`@/../assets/images/placeholders/avatar-placeholder.jpg`, import.meta.url).href;
  });
</script>

<template>
  <TableRow :section="'body'" :is-even="isEvenRow">
    <!--kt-datatable__row&#45;&#45;even-->

    <TableColumn>
      <img :style="{ width: '50px' }" :src="avatarSource" />
    </TableColumn>

    <TableColumn>
      {{ user.name }}
    </TableColumn>

    <TableColumn>
      {{ user.address }}
    </TableColumn>

    <TableColumn>
      <VenueStatusBadge :is-disabled="user.is_disabled" />
    </TableColumn>

    <TableColumn>
      <dash-link
        v-if="checkUser('permissions', USER_PERMISSIONS.writeUsers)"
        :to="{ name: 'edit.user', params: { userId: user.id } }"
        theme="primary"
        theme-mod="outline-hover"
        :icon="IconEdit"
      >
        {{ $t('buttons.edit') }}
      </dash-link>
    </TableColumn>

    <TableColumn>
      <DashButton
        v-if="checkUser('permissions', USER_PERMISSIONS.deleteUsers)"
        :icon="IconTrash"
        theme="danger"
        size="sm"
        onclick="deleteUser(user, user.id)"
        is-pill
        is-icon
      />
    </TableColumn>
  </TableRow>
</template>
