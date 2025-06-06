<script lang="ts" setup>
  import { IconMail } from "@starter-core/icons";
  import { useI18n } from "vue-i18n";
  import UserFormAvatar from "./UserFormAvatar.vue";
  import UserRolesDropdown from "./UserRolesDropdown.vue";
  import UserCountriesDropdown from "./UserCountriesDropdown.vue";
  import { FormInput, FormSwitch } from "@starter-core/dash-ui/src";

  type EmitsType = {
    (event: "uploadAvatar", file: File): void;
  };

  const { t } = useI18n();
  const isDisabled = defineModel("isDisabled", {
    required: true,
    type: Boolean,
  });
  const isOfficeBased = defineModel("isOfficeBased", {
    required: true,
    type: Boolean,
  });
  const role = defineModel("role", { required: true, type: Number });
  const lastName = defineModel("lastName", { required: true, type: String });
  const firstName = defineModel("firstName", { required: true, type: String });
  const country = defineModel("country", { required: true, type: Number });
  const email = defineModel("email", { required: true, type: String });
  const { errors = {}, avatar } = defineProps<{
    errors: any;
    avatar: string | null;
    paidLeavesLeft: number
  }>();
  const emit = defineEmits<EmitsType>();

  const uploadAvatar = (file: File) => {
    emit("uploadAvatar", file);
  };
</script>
<template>
  <div class="kt-section kt-section--first">
    <div class="kt-section__body">
      <h3 class="kt-section__title kt-section__title-lg">
        {{ t("users.user_status") }}:
      </h3>
      <user-roles-dropdown v-model:role="role" />

      <UserCountriesDropdown v-model:country="country" />

      <form-switch
        v-model="isDisabled"
        id="enabled"
        theme="danger"
        type="outline"
        :label="t('users.status.label')"
        :helper-text="`User is  ${isDisabled ? 'disabled' : 'enabled'}`"
      />
      <form-switch
        v-model="isOfficeBased"
        id="enabled"
        theme="danger"
        type="outline"
        :label="'Office Based'"
        :helper-text="`User is  ${isOfficeBased ? '' : 'not'} Office Based`"
      />
    </div>
  </div>

  <div
    class="kt-separator kt-separator--border-dashed kt-separator--space-lg"
  ></div>

  <div class="kt-section">
    <div class="kt-section__body">
      <h3 class="kt-section__title kt-section__title-lg">Customer Info:</h3>
      <div class="form-group form-input form-group--inline">
        <div
          class="form-group__column form-group__column--left form-group__column--inline"
        >
          <label class="form-group__label" for="avatar">{{
            t("users.avatar")
          }}</label>
        </div>
        <div
          class="form-group__column form-group__column--left form-group__column--inline"
        >
          <user-form-avatar
            :src="avatar"
            @change="uploadAvatar"
            is-circle
            is-outline
          />
        </div>
      </div>
      <form-input
        v-model="lastName"
        name="last-name"
        :label="t('users.last_name.label')"
        :error="errors.last_name"
        is-inline
      />
      <form-input
        v-model="firstName"
        name="first-name"
        :label="t('users.first_name.label')"
        :error="errors.first_name"
        is-inline
      />
      <form-input
        v-model="email"
        name="email"
        :label="t('users.email.label')"
        :error="errors.email"
        is-inline
      >
        <template v-slot:prependContent>
          <IconMail />
        </template>
      </form-input>
    </div>
  </div>
</template>
