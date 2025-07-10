<script lang="ts" setup>
  import { IconSave, IconArrowleft } from '@starter-core/icons';
  import { useForm } from 'vee-validate';
  import { watch, computed } from 'vue';
  import { useI18n } from 'vue-i18n';
  import { useRoute } from 'vue-router';
  import { StoreFormBasicInfo } from '../components';
  import { useStoresForm, useUserCheck } from '../composables';
  import type { StoreFormItem } from '../types';
  import { TabbedContent, TabbedContentTab, PageWrapper, PAGE_WRAPPER_SLOTS, SubheaderTitle, SkSection } from '@/components';
  import { USER_PERMISSIONS } from '@/modules/users/constants';
  import { DashButton, DashLink, FormSwitch } from '@starter-core/dash-ui/src';
  const { checkUser } = useUserCheck();

  const { t } = useI18n();
  const personalInformationLabel = t('users.personal-information.label');
  const route = useRoute();
  const isEditPage = computed(() => route.name == 'edit.store');
  const storeId = Number(route.params.storeId);

  const { isLoading, data: formData, createUser, updateUser, uploadAvatar } = useStoresForm(storeId);

  const { handleSubmit, errors, setValues, defineField } = useForm<StoreFormItem>();

  const submitHandler = handleSubmit((values) => {
    if (isEditPage.value) {
      updateUser(values);
    } else {
      createUser(values);
    }
  });

  const uploadAvatarHandler = (file: File) => {
    uploadAvatar(file);
  };

  watch(() => {
    if (formData.value) {
      setValues({
        id: formData.value.id,
        email: formData.value.email,
        name: formData.value.name,
        website: formData.value.website,
        domain: formData.value.domain,
        is_active: formData.value.is_active,
        phone: formData.value.phone,
      });
    }
  }, [formData]);

  const [name] = defineField('name');
  const [isActive] = defineField('is_active');
  const [email] = defineField('email');
  const [website] = defineField('website');
  const [domain] = defineField('domain');
  const [phone] = defineField('phone');
</script>

<template>
  <PageWrapper size="large" justify-content="center">
    <template #[PAGE_WRAPPER_SLOTS.subheaderMain]>
      <SubheaderTitle :title="isEditPage ? 'Edit store' : 'Add store'" :description="`${name ? name : ''}`" />
    </template>
    <template #[PAGE_WRAPPER_SLOTS.subheaderToolbox]>
      <DashLink to="/admin/stores" :icon="IconArrowleft" theme="clean">
        {{ t('buttons.back') }}
      </DashLink>
      <DashButton type="submit" :icon="IconSave" :loading="isLoading" @click="submitHandler">
        {{ t('buttons.save') }}
      </DashButton>
    </template>
    <form autocomplete="off" enctype="multipart/form-data" @submit.prevent="submitHandler">
      <TabbedContent :isLoading="isLoading">
        <TabbedContentTab :label="personalInformationLabel" id="basic-info">
          <SkSection :title="t('stores.store_status')">
            <form-switch
              v-if="checkUser('permissions', USER_PERMISSIONS.deleteStore)"
              v-model="isActive"
              id="enabled"
              theme="success"
              type="outline"
              :label="t('stores.status.label')"
              :helper-text="`Store is  ${!isActive ? 'disabled' : 'enabled'}`"
            />
          </SkSection>
          <hr />
          <SkSection title="Store Info">
            <StoreFormBasicInfo
              v-model:name="name"
              v-model:email="email"
              v-model:website="website"
              v-model:phone="phone"
              v-model:domain="domain"
              :isEditPage="isEditPage"
              :avatar="formData?.avatar_thumbnail"
              @upload-avatar="uploadAvatarHandler"
              :errors="errors"
            />
          </SkSection>
        </TabbedContentTab>
      </TabbedContent>
    </form>
  </PageWrapper>
</template>
