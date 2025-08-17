<script lang="ts" setup>
  import { IconSave, IconArrowleft } from '@starter-core/icons';
  import { useForm } from 'vee-validate';
  import { watch, computed } from 'vue';
  import { useI18n } from 'vue-i18n';
  import { useRoute } from 'vue-router';
  import useAuth from '../../../composables/useAuth';
  import { PostFormBasicInfo } from '../components';
  import { usePostsForm } from '../composables';
  import type { PostFormItem } from '../types';
  import { TabbedContent, TabbedContentTab, PageWrapper, PAGE_WRAPPER_SLOTS, SubheaderTitle, SkSection } from '@/components';
  import { useUserCheck } from '@/modules/users/composables';
  import { USER_PERMISSIONS } from '@/modules/posts/constants';
  import { DashButton, DashLink, FormSwitch } from '@starter-core/dash-ui/src';

  const { t } = useI18n();
  const eventInformationLabel = t('posts.post-information.label');
  const route = useRoute();
  const isEditPage = computed(() => route.name == 'edit.post');
  const postId = Number(route.params.postId);
  const auth = useAuth();
  const { checkUser } = useUserCheck();

  const { isLoading, data: formData, createPost, updatePost, uploadEventImage } = usePostsForm(postId);

  const { handleSubmit, errors, setValues, defineField } = useForm<PostFormItem>();

  const submitHandler = handleSubmit((values) => {
    const payload = {
      ...values,
      user_id: auth.user.id,
    };
    if (isEditPage.value) {
      updatePost(payload);
    } else {
      createPost(payload);
    }
  });

  const uploadEventImageHandler = (file: File) => {
    uploadEventImage(file);
  };

  watch(
    formData,
    (newValue) => {
      if (newValue) {
        setValues({
          id: newValue.id,
          venue_id: newValue.venue_id,
          name: newValue.name,
          description: newValue.description,
          is_boosted: newValue.is_boosted,
          is_active: newValue.is_active,
          post_slot: newValue.post_slot,
        });
      }
    },
    { immediate: true } // Optional: runs immediately on mount
  );
  const [venue_id] = defineField('venue_id');
  const [name] = defineField('name');
  const [description] = defineField('description');
  const [isBoosted] = defineField('is_boosted');
  const [isActive] = defineField('is_active');
  const [postSlot] = defineField('post_slot');
</script>

<template>
  <PageWrapper size="large" justify-content="center">
    <template #[PAGE_WRAPPER_SLOTS.subheaderMain]>
      <SubheaderTitle :title="isEditPage ? 'Edit Post' : 'Add Post'" :description="isEditPage ? `${name}` : ''" />
    </template>
    <template #[PAGE_WRAPPER_SLOTS.subheaderToolbox]>
      <DashLink to="/admin/posts" :icon="IconArrowleft" theme="clean">
        {{ t('buttons.back') }}
      </DashLink>
      <DashButton type="submit" :icon="IconSave" :loading="isLoading" @click="submitHandler">
        {{ t('buttons.save') }}
      </DashButton>
    </template>
    <form autocomplete="off" enctype="multipart/form-data" @submit.prevent="submitHandler">
      <TabbedContent :isLoading="isLoading">
        <TabbedContentTab :label="eventInformationLabel" id="basic-info">
          <SkSection title="Post Info">
            <form-switch
              v-if="checkUser('permissions', USER_PERMISSIONS.deletePosts)"
              v-model="isBoosted"
              id="boosted"
              theme="success"
              type="outline"
              :label="t('posts.boosted.label')"
              :helper-text="`Venue is  ${isBoosted ? 'boosted' : 'not boosted'}`"
            />
            <form-switch
              v-model="isActive"
              id="boosted"
              theme="success"
              type="outline"
              :label="t('posts.status.label')"
              :helper-text="`Venue is  ${isActive ? 'active' : 'disabled'}`"
            />
            <PostFormBasicInfo
              v-if="!isLoading"
              v-model:venue_id="venue_id"
              v-model:name="name"
              v-model:description="description"
              v-model:postSlot="postSlot"
              :errors="errors"
              :eventImage="formData?.images?.thumbnail?.srcset ?? null"
              @uploadEventImage="uploadEventImageHandler"
            />
          </SkSection>
        </TabbedContentTab>
      </TabbedContent>
    </form>
  </PageWrapper>
</template>
