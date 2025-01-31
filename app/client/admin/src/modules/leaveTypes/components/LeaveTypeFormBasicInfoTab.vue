<script lang="ts" setup>
  import { IconMail } from "@starter-core/icons";
  import { useI18n } from "vue-i18n";
  import { FormInput, FormSwitch } from "@starter-core/dash-ui/src";

  const { t } = useI18n();
  const slug = defineModel("slug", { required: true, type: String });
  const name = defineModel("name", { required: true, type: String });
  const isPaid = defineModel("isPaid", { required: true, type: Boolean });
</script>
<template>
  <div class="kt-section">
    <div class="kt-section__body">
      <form-input
        v-model="slug"
        name="slug"
        label="Slug"
        is-inline
      />
      <form-input
        v-model="name"
        name="name"
        label="Name"
        is-inline
      />
      <form-switch
        v-model="isPaid"
        id="enabled"
        :theme="isPaid ? 'success' : 'danger'"
        type="outline"
        label="Paid"
        :helper-text="`Leave Type is  ${isPaid ? 'Paid' : 'Unpaid'}`"
      />
    </div>
  </div>
</template>
