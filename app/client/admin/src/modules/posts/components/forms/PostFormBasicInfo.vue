<script lang="ts" setup>
  import { useI18n } from 'vue-i18n';
  import UserFormAvatar from '@/modules/posts/components/UserFormAvatar.vue';
  import { useUserCheck } from '@/modules/users/composables';
  import { FormInput } from '@starter-core/dash-ui/src';
  import '@vuepic/vue-datepicker/dist/main.css';
  import './EventFormBasicInfo.scss';

  type EmitsType = {
    (event: 'uploadEventImage', file: File): void;
  };

  const { t } = useI18n();
  const venue_id = defineModel('venue_id', { required: true, type: [String, null], default: null });
  const name = defineModel('name', { required: true, type: String });
  const description = defineModel('description', { required: false, type: String });

  const { errors = {} } = defineProps<{
    errors: any;
    eventImage?: string | null;
  }>();
  const emit = defineEmits<EmitsType>();

  const uploadEventImage = (file: File) => {
    emit('uploadEventImage', file);
  };
</script>
<template>
  <div class="form-group form-input form-group--inline">
    <div class="form-group__column form-group__column--left form-group__column--inline">
      <label class="form-group__label" for="avatar">{{ t('events.image') }}</label>
    </div>
    <div class="form-group__column form-group__column--left form-group__column--inline">
      <user-form-avatar :src="eventImage ?? ''" @change="uploadEventImage" is-outline />
    </div>
  </div>
  <form-input v-model="name" name="name" :label="t('events.name.label')" is-inline />
  <form-input v-model="description" name="description" :label="t('events.desc.label')" is-inline />
</template>
