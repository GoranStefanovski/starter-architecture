<script setup lang="ts">
  import { IconTrash, IconEdit } from '@starter-core/icons';
  import { computed, ref } from 'vue';
  import { usePostsForm } from '../composables';
  import type { GetPostDataRowResponse } from '../types';
  import PostStatusBadge from './PostStatusBadge.vue';
  import ConfirmDialog from '@/components/ConfirmDialog/ConfirmDialog.vue';
  import { USER_PERMISSIONS } from '@/modules/posts/constants';
  import { useUserCheck } from '@/modules/users/composables';
  import { DashButton, DashLink, TableColumn, TableRow } from '@starter-core/dash-ui/src';

  interface PostsTableRowProps {
    post: GetPostDataRowResponse;
    isEvenRow: boolean;
  }

  const { checkUser } = useUserCheck();
  const { post, isEvenRow } = defineProps<PostsTableRowProps>();
  const { deleteEvent } = usePostsForm();
  const showConfirmDialog = ref(false);

  const avatarSource = computed(() => {
    return new URL(`@/../assets/images/placeholders/avatar-placeholder.jpg`, import.meta.url).href;
  });

  const confirmDelete = () => {
    deleteEvent(post.id);
    showConfirmDialog.value = false;
  };
</script>

<template>
  <TableRow :section="'body'" :is-even="isEvenRow">
    <!--kt-datatable__row&#45;&#45;even-->

    <TableColumn>
      {{ post.name }}
    </TableColumn>

    <TableColumn>
      <PostStatusBadge :is-active="post.is_boosted" />
    </TableColumn>

    <TableColumn>
      <PostStatusBadge :is-active="post.is_active" />
    </TableColumn>

    <TableColumn>
      <dash-link
        v-if="checkUser('permissions', USER_PERMISSIONS.writePosts)"
        :to="{ name: 'edit.post', params: { post: post.id } }"
        theme="primary"
        theme-mod="outline-hover"
        :icon="IconEdit"
      >
        {{ $t('buttons.edit') }}
      </dash-link>
    </TableColumn>

    <TableColumn>
      <DashButton
        v-if="checkUser('permissions', USER_PERMISSIONS.deletePosts)"
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
    message="Are you sure you want to delete this post?"
    @confirm="confirmDelete"
    @close="showConfirmDialog = false"
  />
</template>
