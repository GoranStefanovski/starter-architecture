<script lang="ts" setup>
  import { IconMail } from '@starter-core/icons';
  import { useI18n } from 'vue-i18n';
  import UserFormAvatar from '../UserFormAvatar.vue';
  import { FormInput } from '@starter-core/dash-ui/src';

  type EmitsType = {
    (event: 'uploadAvatar', file: File): void;
  };

  const { t } = useI18n();
  const name = defineModel('name', { required: true, type: String });
  const venueTypeId = defineModel('venue_type_id', { required: true, type: Number });
  const bio = defineModel('bio', { required: false, type: String });
  const address = defineModel('address', { required: true, type: String });
  const lat = defineModel('lat', { required: true, type: Number });
  const lng = defineModel('lng', { required: true, type: Number });
  const { errors = {}, avatar } = defineProps<{
    errors: any;
    avatar?: string | null;
  }>();
  const emit = defineEmits<EmitsType>();

  const uploadAvatar = (file: File) => {
    emit('uploadAvatar', file);
  };
</script>
<template>
  <div class="form-group form-input form-group--inline">
    <!-- <div class="form-group__column form-group__column--left form-group__column--inline">
      <label class="form-group__label" for="avatar">{{ t('users.avatar') }}</label>
    </div>
    <div class="form-group__column form-group__column--left form-group__column--inline">
      <user-form-avatar :src="avatar" @change="uploadAvatar" is-circle is-outline />
    </div> -->
  </div>
  <form-input v-model="name" name="name" :label="t('venues.name.label')" is-inline />
  <form-input v-model="venueTypeId" name="venue_type" :label="t('venues.venue_type.label')" is-inline />
  <form-input v-model="bio" name="bio" :label="t('venues.bio.label')" is-inline />
  <form-input v-model="address" name="address" :label="t('venues.address.label')" is-inline />
  <form-input v-model="lat" type="number" name="lat" :label="t('venues.address.lat')" is-inline />
  <form-input v-model="lng" type="number" name="lng" :label="t('venues.address.lng')" is-inline />
</template>
