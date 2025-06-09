<script lang="ts" setup>
  import { IconSave, IconArrowleft } from '@starter-core/icons';
  import { useForm } from 'vee-validate';
  import { watch, computed } from 'vue';
  import { useI18n } from 'vue-i18n';
  import { useRoute } from 'vue-router';
  import useAuth from '../../../composables/useAuth';
  import { EventFormBasicInfo } from '../components';
  import { useEventsForm } from '../composables';
  import type { UserFormItem } from '../types';
  import { TabbedContent, TabbedContentTab, PageWrapper, PAGE_WRAPPER_SLOTS, SubheaderTitle, SkSection } from '@/components';
  import { DashButton, DashLink } from '@starter-core/dash-ui/src';
  const { t } = useI18n();
  const personalInformationLabel = t('users.personal-information.label');
  const route = useRoute();
  const isEditPage = computed(() => route.name == 'edit.event');
  const eventId = Number(route.params.eventId);
  const auth = useAuth();

  const validationSchema = {
    name(value: string) {
      if (value?.length >= 5) return true;
      return 'Name needs to be at least 5 characters.';
    },
  };

  const { isLoading, data: formData, createEvent, updateEvent, musicGenres } = useEventsForm(eventId);

  const { handleSubmit, errors, setValues, defineField } = useForm<UserFormItem>({
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
          country: newValue.country,
          city: newValue.city,
          address: newValue.address,
          lng: newValue.lng,
          lat: newValue.lat,
          event_start: newValue.event_start,
          event_end: newValue.event_end,
          tickets: newValue.tickets,
          genreIds: newValue.genreIds,
        });
      }
    },
    { immediate: true } // Optional: runs immediately on mount
  );
  const [venue_id] = defineField('venue_id');
  const [name] = defineField('name');
  const [description] = defineField('description');
  const [country] = defineField('country');
  const [city] = defineField('city');
  const [address] = defineField('address');
  const [lng] = defineField('lng');
  const [lat] = defineField('lat');
  const [event_start] = defineField('event_start');
  const [event_end] = defineField('event_end');
  const [tickets] = defineField('tickets');
  const [genreIds] = defineField('genreIds');
</script>

<template>
  <PageWrapper size="large" justify-content="center">
    <template #[PAGE_WRAPPER_SLOTS.subheaderMain]>
      <SubheaderTitle :title="isEditPage ? 'Edit Event' : 'Add Event'" :description="isEditPage ? `${name}` : ''" />
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
        <TabbedContentTab :label="personalInformationLabel" id="basic-info">
          <SkSection title="Customer Info">
            <EventFormBasicInfo
              v-model:venue_id="venue_id"
              v-model:name="name"
              v-model:description="description"
              v-model:country="country"
              v-model:city="city"
              v-model:address="address"
              v-model:lng="lng"
              v-model:lat="lat"
              v-model:event_start="event_start"
              v-model:event_end="event_end"
              v-model:tickets="tickets"
              v-model:genreIds="genreIds"
              :music-genres="musicGenres"
              :errors="errors"
            />
          </SkSection>
        </TabbedContentTab>
      </TabbedContent>
    </form>
  </PageWrapper>
</template>
