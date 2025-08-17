<script lang="ts" setup>
  import { IconSave, IconArrowleft } from '@starter-core/icons';
  import { useForm } from 'vee-validate';
  import { watch, computed } from 'vue';
  import { useI18n } from 'vue-i18n';
  import { useRoute } from 'vue-router';
  import useAuth from '../../../composables/useAuth';
  import { usePostSlotsForm } from '../composables';
  import type { PostSlotFormItem } from '../types';
  import { TabbedContent, TabbedContentTab, PageWrapper, PAGE_WRAPPER_SLOTS, SubheaderTitle, SkSection } from '@/components';
  import { DashButton, DashLink, FormSwitch } from '@starter-core/dash-ui/src';
  import { FormInput } from '@starter-core/dash-ui/src';
  const { t } = useI18n();
  const postSlotInformationLabel = t('post_slots.post-slot-information.label');
  const route = useRoute();
  const isEditPage = computed(() => route.name == 'edit.post-slot');
  const postSlotId = Number(route.params.postSlotId);
  const auth = useAuth();

  const { isLoading, data: formData, createPost, updatePost } = usePostSlotsForm(postSlotId);

  const { handleSubmit, errors, setValues, defineField } = useForm<PostSlotFormItem>();

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

  watch(
    formData,
    (newValue) => {
      if (newValue) {
        setValues({
          id: newValue.id,
          name: newValue.name,
          is_active: newValue.is_active,
        });
      }
    },
    { immediate: true }
  );
  const [name] = defineField('name');
  const [isActive] = defineField('is_active');
</script>

<template>
  <PageWrapper size="large" justify-content="center">
    <template #[PAGE_WRAPPER_SLOTS.subheaderMain]>
      <SubheaderTitle :title="isEditPage ? 'Edit Post Slot' : 'Add Post Slot'" :description="isEditPage ? `${name}` : ''" />
    </template>
    <template #[PAGE_WRAPPER_SLOTS.subheaderToolbox]>
      <DashLink to="/admin/post-slots" :icon="IconArrowleft" theme="clean">
        {{ t('buttons.back') }}
      </DashLink>
      <DashButton type="submit" :icon="IconSave" :loading="isLoading" @click="submitHandler">
        {{ t('buttons.save') }}
      </DashButton>
    </template>
    <form autocomplete="off" enctype="multipart/form-data" @submit.prevent="submitHandler">
      <TabbedContent :isLoading="isLoading">
        <TabbedContentTab :label="postSlotInformationLabel" id="basic-info">
          <SkSection title="Post Slot Info">
            <form-switch
              v-model="isActive"
              id="is_active"
              theme="success"
              type="outline"
              :label="t('post_slots.status.label')"
              :helper-text="`Post Slot is  ${isActive ? 'active' : 'disabled'}`"
            />
            <form-input v-model="name" name="name" :label="t('post_slots.name.label')" is-inline />
          </SkSection>
        </TabbedContentTab>
      </TabbedContent>
    </form>
  </PageWrapper>
</template>
