<script setup lang="ts">
  import { IconEdit } from '@starter-core/icons';
  import { ref } from 'vue';
  import type { GetPostSlotDataRowResponse } from '../types';
  import PostSlotStatusBadge from './PostSlotStatusBadge.vue';
  import { USER_PERMISSIONS } from '@/modules/post-slots/constants';
  import { useUserCheck } from '@/modules/users/composables';
  import { DashLink, TableColumn, TableRow } from '@starter-core/dash-ui/src';

  interface EventsTableRowProps {
    post_slot: GetPostSlotDataRowResponse;
    isEvenRow: boolean;
  }

  const { checkUser } = useUserCheck();
  const { post_slot, isEvenRow } = defineProps<EventsTableRowProps>();
</script>

<template>
  <TableRow :section="'body'" :is-even="isEvenRow">
    <!--kt-datatable__row&#45;&#45;even-->

    <TableColumn>
      {{ post_slot.name }}
    </TableColumn>

    <TableColumn>
      <PostSlotStatusBadge :is-active="post_slot.is_active" />
    </TableColumn>

    <TableColumn>
      <dash-link
        v-if="checkUser('permissions', USER_PERMISSIONS.writePosts)"
        :to="{ name: 'edit.post-slot', params: { postSlotId: post_slot.id } }"
        theme="primary"
        theme-mod="outline-hover"
        :icon="IconEdit"
      >
        {{ $t('buttons.edit') }}
      </dash-link>
    </TableColumn>
  </TableRow>
</template>
