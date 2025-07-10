<script setup lang="ts">
  import { IconTrash, IconEdit } from '@starter-core/icons';
  import { computed, ref } from 'vue';
  import { useStoresForm, useUserCheck } from '../composables';
  import type { GetStoreResponse } from '../types';
  import { USER_PERMISSIONS } from '@/modules/users/constants';

  import { DashButton, DashLink, ModalComponent, TableColumn, TableRow } from '@starter-core/dash-ui/src';
  import StoreStatusBadge from './StoreStatusBadge.vue';

  interface UsersTableRowProps {
    store: GetStoreResponse;
    isEvenRow: boolean;
  }

  const { checkUser } = useUserCheck();
  const { store, isEvenRow } = defineProps<UsersTableRowProps>();
  const { deleteStore } = useStoresForm(store.id);

  const avatarSource = computed(() => {
    return new URL(`@/../assets/images/placeholders/avatar-placeholder.jpg`, import.meta.url).href;
  });
  const deleteModalRef = ref<InstanceType<typeof ModalComponent> | null>(null);

  const onDeleteClick = () => {
    deleteModalRef.value?.show();
  };

  const confirmDelete = () => {
    deleteStore(store.id);
  };
</script>

<template>
  <TableRow :section="'body'" :is-even="isEvenRow">
    <!--kt-datatable__row&#45;&#45;even-->

    <TableColumn>
      <img :style="{ width: '50px' }" :src="avatarSource" />
    </TableColumn>

    <TableColumn>
      {{ store.name }}
    </TableColumn>

    <TableColumn>
      {{ store.domain }}
    </TableColumn>

    <TableColumn>
      {{ store.email }}
    </TableColumn>

    <TableColumn>
      {{ store.phone }}
    </TableColumn>

    <TableColumn>
      <StoreStatusBadge :is-active="store.is_active" />
    </TableColumn>

    <TableColumn>
      <dash-link
        v-if="checkUser('permissions', USER_PERMISSIONS.writeStore)"
        :to="{ name: 'edit.store', params: { storeId: store.id } }"
        theme="primary"
        theme-mod="outline-hover"
        :icon="IconEdit"
      >
        {{ $t('buttons.edit') }}
      </dash-link>
    </TableColumn>

    <TableColumn>
      <DashButton
        v-if="checkUser('permissions', USER_PERMISSIONS.deleteStore)"
        :icon="IconTrash"
        theme="danger"
        size="sm"
        @click="onDeleteClick"
        is-pill
        is-icon
      />
    </TableColumn>
    <ModalComponent
      ref="deleteModalRef"
      :title="`Delete ${store.name}`"
      confirm-text="Delete"
      cancel-text="Cancel"
      show-cancel
      @confirm="confirmDelete"
      @cancel="() => {}"
    >
      <template #default>
        <p>Are you sure you want to delete this store?</p>
      </template>
    </ModalComponent>
  </TableRow>
</template>
