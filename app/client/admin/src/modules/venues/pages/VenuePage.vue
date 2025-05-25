<script lang="ts" setup>
  import { IconSave, IconArrowleft } from '@starter-core/icons';
  import { useForm } from 'vee-validate';
  import { watch, computed } from 'vue';
  import { useI18n } from 'vue-i18n';
  import { useRoute } from 'vue-router';
  import { VenueFormBasicInfo } from '../components';
  import { useUsersForm } from '../composables';
  import type { UserFormItem } from '../types';
  import { TabbedContent, TabbedContentTab, PageWrapper, PAGE_WRAPPER_SLOTS, SubheaderTitle, SkSection } from '@/components';
  import { DashButton, DashLink } from '@starter-core/dash-ui/src';

  const { t } = useI18n();
  const personalInformationLabel = t('users.personal-information.label');
  const route = useRoute();
  const isEditPage = computed(() => route.name == 'edit.user');
  const userId = Number(route.params.userId);

  const validationSchema = {
    name(value: string) {
      if (value?.length >= 5) return true;
      return 'Name needs to be at least 5 characters.';
    },
  };

  const { isLoading, data: formData, createUser, updateUser } = useUsersForm(userId);

  const { handleSubmit, errors, setValues, defineField } = useForm<UserFormItem>({
    validationSchema,
  });

  const submitHandler = handleSubmit((values) => {
    if (isEditPage.value) {
      updateUser(values);
    } else {
      createUser(values);
    }
  });

  watch(() => {
    if (formData.value) {
      setValues({
        id: formData.value.id,
        name: formData.value.name,
        address: formData.value.address,
        venue_type_id: formData.value.venue_type_id,
      });
    }
  }, [formData]);

  const [name] = defineField('name');
  const [address] = defineField('address');
  const [venueTypeId] = defineField('venue_type_id');
</script>

<template>
  <PageWrapper size="large" justify-content="center">
    <template #[PAGE_WRAPPER_SLOTS.subheaderMain]>
      <SubheaderTitle :title="isEditPage ? 'Edit Venue' : 'Add Venue'" :description="isEditPage ? `${name}` : ''" />
    </template>
    <template #[PAGE_WRAPPER_SLOTS.subheaderToolbox]>
      <DashLink to="/admin/venues" :icon="IconArrowleft" theme="clean">
        {{ t('buttons.back') }}
      </DashLink>
      <DashButton type="submit" :icon="IconSave" :loading="isLoading" @click="submitHandler">
        {{ t('buttons.save') }}
      </DashButton>
    </template>
    <form autocomplete="off" enctype="multipart/form-data" @submit.prevent="submitHandler">
      <TabbedContent :isLoading="isLoading">
        <TabbedContentTab :label="personalInformationLabel" id="basic-info">
          <SkSection title="Customer Info">
            <VenueFormBasicInfo
              v-model:name="name"
              v-model:address="address"
              v-model:venue_type_id="venueTypeId"
              :errors="errors"
            />
          </SkSection>
        </TabbedContentTab>
      </TabbedContent>
    </form>
  </PageWrapper>
</template>
