<script lang="ts" setup>
  import { IconMail } from "@starter-core/icons";
  import { useI18n } from "vue-i18n";
  import { FormInput, FormSwitch } from "@starter-core/dash-ui/src";

  const { t } = useI18n();
  const slug = defineModel("slug", { required: true, type: String });
  const name = defineModel("name", { required: true, type: String });
  const isPaid = defineModel("is_paid", { required: true, type: Boolean });
</script>
<template>
<div class="kt-section kt-section--first">
    <div class="kt-section__body">
      <h3 class="kt-section__title kt-section__title-lg">
        {{ t("leaveTypes.user_status") }}:
      </h3>
      <form-switch
        v-model="isPaid"
        id="enabled"
        theme="danger"
        type="outline"
        :label="t('users.status.label')"
        :helper-text="`Leave Type is  ${isPaid ? 'disabled' : 'enabled'}`"
      />
    </div>
  </div>

  <div
    class="kt-separator kt-separator--border-dashed kt-separator--space-lg"
  ></div>

  <div class="kt-section">
    <div class="kt-section__body">
      <h3 class="kt-section__title kt-section__title-lg">Leave Type Info:</h3>
      <form-input
        v-model="slug"
        name="slug"
        :label="t('leaveTpyes.last_name.label')"
        is-inline
      />
      <form-input
        v-model="name"
        name="name"
        :label="t('leaveTpyes.first_name.label')"
        is-inline
      />
    </div>
  </div>
</template>
