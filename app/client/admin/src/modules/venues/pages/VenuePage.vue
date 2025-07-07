<script lang="ts" setup>
  import { IconSave, IconArrowleft } from '@starter-core/icons';
  import { useForm } from 'vee-validate';
  import { watch, computed } from 'vue';
  import { useI18n } from 'vue-i18n';
  import { useRoute } from 'vue-router';
  import useAuth from '../../../composables/useAuth';
  import { VenueFormBasicInfo } from '../components';
  import { useVenuesForm } from '../composables';
  import type { UserFormItem } from '../types';
  import { TabbedContent, TabbedContentTab, PageWrapper, PAGE_WRAPPER_SLOTS, SubheaderTitle, SkSection } from '@/components';
  import { DashButton, DashLink, FormSwitch } from '@starter-core/dash-ui/src';
  import { useUserCheck } from '@/modules/users/composables';
  import { USER_PERMISSIONS } from '@/modules/users/constants';
  import { EventFormBasicInfo } from '@/modules/events/components';
  const { t } = useI18n();
  const personalInformationLabel = t('venues.personal-information.label');
  const route = useRoute();
  const isEditPage = computed(() => route.name == 'edit.venue');
  const venueId = Number(route.params.venueId);
  const auth = useAuth();
  const { checkUser } = useUserCheck();

  const validationSchema = {
    name(value: string) {
      if (value?.length >= 5) return true;
      return 'Name needs to be at least 5 characters.';
    },
  };

  const {
    isLoading,
    data: formData,
    createVenue,
    updateVenue,
    venueTypes,
    uploadVenueImage,
    deleteVenueImage,
  } = useVenuesForm(venueId);

  const { handleSubmit, errors, setValues, defineField } = useForm<UserFormItem>({
    validationSchema,
  });

  const submitHandler = handleSubmit((values) => {
    const payload = {
      ...values,
      user_id: auth.user.id,
    };
    if (isEditPage.value) {
      updateVenue(payload);
    } else {
      createVenue(payload);
    }
  });

  const uploadVenueImageHandler = (file: File) => {
    uploadVenueImage(file);
  };

  const deleteVenueImageHandler = (imgId: number) => {
    deleteVenueImage(imgId); // 🎯 pass imgId to mutationFn
  };

  watch(
    formData,
    (newValue) => {
      if (newValue) {
        setValues({
          id: newValue.id,
          user_id: auth.user.id,
          name: newValue.name,
          bio: newValue.bio,
          address: newValue.address,
          lng: newValue.lng,
          lat: newValue.lat,
          email: newValue.email,
          phone_number: newValue.phone_number,
          venue_type_id: newValue.venue_type_id,
          country: newValue.country,
          city: newValue.city,
          is_active: newValue.is_active,
        });
      }
    },
    { immediate: true } // Optional: runs immediately on mount
  );
  const [name] = defineField('name');
  const [venueTypeId] = defineField('venue_type_id');
  const [bio] = defineField('bio');
  const [address] = defineField('address');
  const [lng] = defineField('lng');
  const [lat] = defineField('lat');
  const [email] = defineField('email');
  const [phone_number] = defineField('phone_number');
  const [city] = defineField('city');
  const [country] = defineField('country');
  const [isActive] = defineField('is_active');
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
            <form-switch
              v-if="checkUser('permissions', USER_PERMISSIONS.deleteVenues)"
              v-model="isActive"
              id="enabled"
              theme="success"
              type="outline"
              :label="t('venues.status.label')"
              :helper-text="`Venue is  ${isActive ? 'enabled' : 'disabled'}`"
            />
            <VenueFormBasicInfo
              v-model:name="name"
              v-model:venue_type_id="venueTypeId"
              v-model:bio="bio"
              v-model:address="address"
              v-model:lng="lng"
              v-model:lat="lat"
              v-model:email="email"
              v-model:phone_number="phone_number"
              v-model:city="city"
              v-model:country="country"
              :venue-types="venueTypes"
              :venueImages="formData?.images ?? []"
              :errors="errors"
              @uploadVenueImage="uploadVenueImageHandler"
              @delete-venue-image="deleteVenueImageHandler"
            />
          </SkSection>
        </TabbedContentTab>
      </TabbedContent>
    </form>
  </PageWrapper>
</template>
