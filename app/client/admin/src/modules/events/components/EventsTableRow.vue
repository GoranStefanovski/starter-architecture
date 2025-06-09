<script setup lang="ts">
  import { IconTrash, IconEdit } from '@starter-core/icons';
  import { computed } from 'vue';
  import type { GetEventResponse } from '../types';
  import EventStatusBadge from './EventStatusBadge.vue';
  import { USER_PERMISSIONS } from '@/modules/events/constants';
  import { useUserCheck } from '@/modules/users/composables';
  import { DashButton, DashLink, TableColumn, TableRow } from '@starter-core/dash-ui/src';

  interface EventsTableRowProps {
    event: GetEventResponse;
    isEvenRow: boolean;
  }

  const { checkUser } = useUserCheck();
  const { event, isEvenRow } = defineProps<EventsTableRowProps>();

  const avatarSource = computed(() => {
    // if (event.avatar_thumbnail) {
    //   return event.avatar_thumbnail;
    // }
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
      {{ event.name }}
    </TableColumn>

    <TableColumn>
      {{ event.address }}
    </TableColumn>

    <TableColumn>
      <EventStatusBadge :is-disabled="event.event_start < new Date()" />
    </TableColumn>

    <TableColumn>
      <dash-link
        v-if="checkUser('permissions', USER_PERMISSIONS.writeEvents)"
        :to="{ name: 'edit.event', params: { eventId: event.id } }"
        theme="primary"
        theme-mod="outline-hover"
        :icon="IconEdit"
      >
        {{ $t('buttons.edit') }}
      </dash-link>
    </TableColumn>

    <TableColumn>
      <DashButton
        v-if="checkUser('permissions', USER_PERMISSIONS.deleteEvents)"
        :icon="IconTrash"
        theme="danger"
        size="sm"
        onclick="deleteUser(event, user.id)"
        is-pill
        is-icon
      />
    </TableColumn>
  </TableRow>
</template>
