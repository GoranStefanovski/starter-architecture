<script setup lang="ts">
  import { IconTrash, IconEdit } from '@starter-core/icons';
  import { computed, ref } from 'vue';
  import { useCategoriesForm, useUserCheck } from '../composables';
  import type { GetCategoryResponse } from '../types';
  import { USER_PERMISSIONS } from '@/modules/users/constants';

  import { DashButton, DashLink, ModalComponent, TableColumn, TableRow } from '@starter-core/dash-ui/src';
  import StoreStatusBadge from './StoreStatusBadge.vue';

  interface UsersTableRowProps {
    category: GetCategoryResponse;
    isEvenRow: boolean;
  }

  const { checkUser } = useUserCheck();
  const { category, isEvenRow } = defineProps<UsersTableRowProps>();
  const { deleteCategory } = useCategoriesForm(category.id);

  const deleteModalRef = ref<InstanceType<typeof ModalComponent> | null>(null);

  const onDeleteClick = () => {
    deleteModalRef.value?.show();
  };

  const confirmDelete = () => {
    deleteCategory(category.id);
  };
</script>

<template>
  <TableRow :section="'body'" :is-even="isEvenRow">
    <!--kt-datatable__row&#45;&#45;even-->

    <TableColumn>
      {{ category.name }}
    </TableColumn>

    <TableColumn>
      <StoreStatusBadge :is-active="category.is_active" />
    </TableColumn>

    <TableColumn>
      <dash-link
        v-if="checkUser('permissions', USER_PERMISSIONS.writeStore)"
        :to="{ name: 'edit.category', params: { categoryId: category.id } }"
        theme="primary"
        theme-mod="outline-hover"
        :icon="IconEdit"
      >
        {{ $t('buttons.edit') }}
      </dash-link>
    </TableColumn>

    <TableColumn>
      <DashButton
        v-if="checkUser('permissions', USER_PERMISSIONS.deleteCategory)"
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
      :title="`Delete ${category.name}`"
      confirm-text="Delete"
      cancel-text="Cancel"
      show-cancel
      @confirm="confirmDelete"
      @cancel="() => {}"
    >
      <template #default>
        <p>Are you sure you want to delete this category?</p>
      </template>
    </ModalComponent>
  </TableRow>
</template>
