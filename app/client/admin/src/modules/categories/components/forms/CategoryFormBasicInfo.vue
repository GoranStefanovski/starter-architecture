<script lang="ts" setup>
  import { IconMail } from '@starter-core/icons';
  import { useI18n } from 'vue-i18n';
  import { FormInput } from '@starter-core/dash-ui/src';
  import { useUserCheck } from '../../composables';
  import { USER_PERMISSIONS } from '@/modules/users/constants';

  const { checkUser } = useUserCheck();
  const { t } = useI18n();
  const name = defineModel('name', { required: true, type: String });
  const email = defineModel('slug', { required: true, type: String });
  const website = defineModel('description', { required: true, type: String });
  const { errors = {}, isEditPage } = defineProps<{
    errors: any;
    avatar: string | null;
    isEditPage: boolean;
  }>();
</script>
<template>
  <form-input v-model="name" name="name" :label="t('categories.name.label')" :error="errors.name" is-inline />
  <form-input v-model="website" name="slug" :label="t('categories.website.label')" :error="errors.slug" is-inline />
</template>
