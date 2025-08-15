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
  import { USER_PERMISSIONS } from '@/modules/users/constants';
  import { DashButton, DashLink, FormSwitch } from '@starter-core/dash-ui/src';

  const { t } = useI18n();
  const eventInformationLabel = t('events.event-information.label');
  const route = useRoute();
  const isEditPage = computed(() => route.name == 'edit.event');
  const postId = Number(route.params.postId);
  const auth = useAuth();
  const { checkUser } = useUserCheck();

  const validationSchema = {
    name(value: string) {
      if (value?.length >= 5) return true;
      return 'Name needs to be at least 5 characters.';
    },
  };

  const { isLoading, data: formData, createEvent, updateEvent, uploadEventImage } = usePostsForm(postId);

  const { handleSubmit, errors, setValues, defineField } = useForm<PostFormItem>({
    validationSchema,
  });

  const submitHandler = handleSubmit((values) => {
    const payload = {
      ...values,
      user_id: auth.user.id,
    };
    if (isEditPage.value) {
      updateEvent(payload);
    } else {
      createEvent(payload);
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
          user_id: auth.user.id,
          venue_id: newValue.venue_id,
          name: newValue.name,
          description: newValue.description,
          is_boosted: newValue.is_boosted,
          is_active: newValue.is_active,
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
</script>

<template>
  <PageWrapper size="large" justify-content="center">
    <template #[PAGE_WRAPPER_SLOTS.subheaderMain]>
      <SubheaderTitle :title="isEditPage ? 'Edit Post' : 'Add Post'" :description="isEditPage ? `${name}` : ''" />
    </template>
    <template #[PAGE_WRAPPER_SLOTS.subheaderToolbox]>
      <DashLink to="/admin/events" :icon="IconArrowleft" theme="clean">
        {{ t('buttons.back') }}
      </DashLink>
      <DashButton type="submit" :icon="IconSave" :loading="isLoading" @click="submitHandler">
        {{ t('buttons.save') }}
      </DashButton>
    </template>
    <form autocomplete="off" enctype="multipart/form-data" @submit.prevent="submitHandler">
      <TabbedContent :isLoading="isLoading">
        <TabbedContentTab :label="eventInformationLabel" id="basic-info">
          <SkSection title="Event Info">
            <form-switch
              v-if="checkUser('permissions', USER_PERMISSIONS.deleteEvents)"
              v-model="isBoosted"
              id="boosted"
              theme="success"
              type="outline"
              :label="t('venues.boosted.label')"
              :helper-text="`Venue is  ${isBoosted ? 'boosted' : 'not boosted'}`"
            />
            <form-switch
              v-model="isActive"
              id="boosted"
              theme="danger"
              type="outline"
              :label="t('venues.status.label')"
              :helper-text="`Venue is  ${isActive ? 'active' : 'disabled'}`"
            />
            <PostFormBasicInfo
              v-if="!isLoading"
              v-model:venue_id="venue_id"
              v-model:name="name"
              v-model:description="description"
              :music-genres="musicGenres"
              :ticket-types="ticketTypes"
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
