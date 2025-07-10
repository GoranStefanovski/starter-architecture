<script lang="ts" setup>
  import { IconSave, IconArrowleft } from '@starter-core/icons';
  import { useForm } from 'vee-validate';
  import { watch, computed, ref, onMounted } from 'vue';
  import { useI18n } from 'vue-i18n';
  import { useRoute } from 'vue-router';
  import { StoreFormBasicInfo } from '../components';
  import { useStoresForm, useUserCheck } from '../composables';
  import type { StoreFormItem } from '../types';
  import { TabbedContent, TabbedContentTab, PageWrapper, PAGE_WRAPPER_SLOTS, SubheaderTitle, SkSection } from '@/components';
  import { USER_PERMISSIONS } from '@/modules/users/constants';
  import { DashButton, DashLink, FormSwitch, FormDropdown } from '@starter-core/dash-ui/src';
  import axios from 'axios';
  const { checkUser } = useUserCheck();

  const { t } = useI18n();
  const personalInformationLabel = t('users.personal-information.label');
  const route = useRoute();
  const isEditPage = computed(() => route.name == 'edit.store');
  const storeId = Number(route.params.storeId);

  const { isLoading, data: formData, createStore, updateStore, uploadAvatar } = useStoresForm(storeId);

  const { handleSubmit, errors, setValues, defineField } = useForm<StoreFormItem>();

  const submitHandler = handleSubmit((values) => {
    if (isEditPage.value) {
      updateStore(values);
    } else {
      createStore(values);
    }
  });

  const uploadAvatarHandler = (file: File) => {
    uploadAvatar(file);
  };

  const userOptions = ref<{ id: number; label: string }[]>([]);

  // 👇 Fetch all users from API
  const fetchUsers = async () => {
    try {
      const response = await axios.get('/user/all'); // Adjust API path
      userOptions.value = response.data.map((user: any) => ({
        id: user.id,
        label: `${user.first_name} (${user.last_name})`,
        name: `${user.first_name} ${user.last_name}`,
      }));
    } catch (error) {
      console.error('Failed to fetch users:', error);
    }
  };

  onMounted(fetchUsers);

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
        user_id: formData.value.user_id,
      });
    }
  }, [formData]);

  const [name] = defineField('name');
  const [isActive] = defineField('is_active');
  const [email] = defineField('email');
  const [website] = defineField('website');
  const [domain] = defineField('domain');
  const [phone] = defineField('phone');
  const [userId] = defineField('user_id');
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
          <SkSection v-if="checkUser('permissions', USER_PERMISSIONS.deleteStore)" :title="t('stores.store_status')">
            <form-switch
              v-model="isActive"
              id="enabled"
              theme="success"
              type="outline"
              :label="t('stores.status.label')"
              :helper-text="`Store is  ${!isActive ? 'disabled' : 'enabled'}`"
            />
          </SkSection>
          <SkSection v-if="checkUser('permissions', USER_PERMISSIONS.deleteStore)" title="Store Owner">
            <FormDropdown
              v-model="userId"
              id="user_id"
              :options="userOptions"
              label="Store Owner"
              :errors="[errors?.user_id]"
              placeholder="Select a user"
              is-inline
              readonly
            />
          </SkSection>
          <hr v-if="checkUser('permissions', USER_PERMISSIONS.deleteStore)" />
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
