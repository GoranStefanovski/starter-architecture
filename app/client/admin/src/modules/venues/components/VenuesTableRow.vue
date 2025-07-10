<script setup lang="ts">
  import { IconTrash, IconEdit } from '@starter-core/icons';
  import { ref, computed } from 'vue';
  import type { GetVenueResponse } from '../types';
  import VenueStatusBadge from './VenueStatusBadge.vue';
  import { useUserCheck } from '@/modules/users/composables';
  import { USER_PERMISSIONS } from '@/modules/venues/constants';
  import { DashButton, DashLink, TableColumn, TableRow } from '@starter-core/dash-ui/src';
  import { useVenuesForm } from '../composables';
  import ConfirmDialog from '@/components/ConfirmDialog/ConfirmDialog.vue';

  interface VenuesTableRowProps {
    venue: GetVenueResponse;
    isEvenRow: boolean;
  }

  const { checkUser } = useUserCheck();
  const { venue, isEvenRow } = defineProps<VenuesTableRowProps>();
  const { deleteVenue } = useVenuesForm();
  const showConfirmDialog = ref(false);

  const venueLogo = computed(() => {
    if (venue.logo) {
      return venue.logo;
    }
    return new URL(`@/../assets/images/placeholders/avatar-placeholder.jpg`, import.meta.url).href;
  });

  const confirmDelete = () => {
    deleteVenue(venue.id);
    showConfirmDialog.value = false;
  };
</script>

<template>
  <TableRow :section="'body'" :is-even="isEvenRow">
    <!--kt-datatable__row&#45;&#45;even-->

    <TableColumn>
      <img :style="{ width: '50px' }" :srcset="venueLogo" />
    </TableColumn>

    <TableColumn>
      {{ venue.name }}
    </TableColumn>

    <TableColumn>
      {{ venue.address }}
    </TableColumn>

    <TableColumn>
      <VenueStatusBadge :is-activated="venue.is_active" />
    </TableColumn>

    <TableColumn>
      <VenueStatusBadge :is-activated="venue.is_boosted" />
    </TableColumn>

    <TableColumn>
      <dash-link
        v-if="checkUser('permissions', USER_PERMISSIONS.writeVenues)"
        :to="{ name: 'edit.venue', params: { venueId: venue.id } }"
        theme="primary"
        theme-mod="outline-hover"
        :icon="IconEdit"
      >
        {{ $t('buttons.edit') }}
      </dash-link>
    </TableColumn>

    <TableColumn>
      <DashButton
        v-if="checkUser('permissions', USER_PERMISSIONS.deleteVenues)"
        :icon="IconTrash"
        theme="danger"
        size="sm"
        @click="showConfirmDialog = true"
        is-pill
        is-icon
      />
    </TableColumn>
  </TableRow>
  <ConfirmDialog
    :show="showConfirmDialog"
    message="Are you sure you want to delete this venue?"
    @confirm="confirmDelete"
    @close="showConfirmDialog = false"
  />
</template>
