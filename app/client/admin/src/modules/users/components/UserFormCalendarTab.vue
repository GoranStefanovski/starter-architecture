<script lang="ts" setup>
  import { useI18n } from "vue-i18n";
  import { FormInput } from "@starter-core/dash-ui/src";

  const { t } = useI18n();
  const password = defineModel("password", { required: true });
</script>
<template>
  <div class="kt-section">
    <div class="kt-section__body">
      <h3 class="kt-section__title kt-section__title-lg">
        Leave Days:
      </h3>

    </div>
  </div>
</template>
