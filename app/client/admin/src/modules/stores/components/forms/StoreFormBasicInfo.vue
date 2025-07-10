<script lang="ts" setup>
  import { IconMail } from '@starter-core/icons';
  import { useI18n } from 'vue-i18n';
  import { FormInput } from '@starter-core/dash-ui/src';
  import StoreFormAvatar from '../StoreFormAvatar.vue';
  import { useUserCheck } from '../../composables';
  import { USER_PERMISSIONS } from '@/modules/users/constants';

  type EmitsType = {
    (event: 'uploadAvatar', file: File): void;
  };
  const { checkUser } = useUserCheck();
  const { t } = useI18n();
  const name = defineModel('name', { required: true, type: String });
  const email = defineModel('email', { required: true, type: String });
  const website = defineModel('website', { required: true, type: String });
  const domain = defineModel('domain', { required: true, type: String });
  const phone = defineModel('phone', { required: true, type: String });
  const {
    errors = {},
    avatar,
    isEditPage,
  } = defineProps<{
    errors: any;
    avatar: string | null;
    isEditPage: boolean;
  }>();
  const emit = defineEmits<EmitsType>();

  const uploadAvatar = (file: File) => {
    emit('uploadAvatar', file);
  };
</script>
<template>
  <div class="form-group form-input form-group--inline">
    <div class="form-group__column form-group__column--left form-group__column--inline">
      <label class="form-group__label" for="avatar">{{ t('stores.logo') }}</label>
    </div>
    <div class="form-group__column form-group__column--left form-group__column--inline">
      <store-form-avatar :src="avatar" @change="uploadAvatar" is-circle is-outline />
    </div>
  </div>
  <form-input v-model="name" name="first-name" :label="t('stores.name.label')" :error="errors.name" is-inline />
  <form-input v-model="website" name="website" :label="t('stores.website.label')" :error="errors.website" is-inline />
  <form-input v-model="domain" name="domain" :label="t('stores.domain.label')" :error="errors.domain" is-inline />
  <form-input v-model="phone" name="phone" :label="t('stores.phone.label')" :error="errors.phone" is-inline />
  <form-input
    v-if="checkUser('permissions', USER_PERMISSIONS.writeStore)"
    v-model="email"
    name="email"
    :label="t('stores.email.label')"
    is-inline
  >
    <template v-slot:prependContent>
      <IconMail />
    </template>
  </form-input>
  <form-input
    v-else
    v-model="email"
    name="email"
    :label="t('stores.email.label')"
    helper-text="You can't update your email."
    is-inline
    readonly
  >
    <template v-slot:prependContent>
      <IconMail />
    </template>
  </form-input>
</template>
