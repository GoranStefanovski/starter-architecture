<script lang="ts" setup>
  import { FormInput, FormSwitch } from "@starter-core/dash-ui/src";
  import { IconMail } from "@starter-core/icons";
  import { useI18n } from "vue-i18n";


  const { t } = useI18n();
  const userId = defineModel("userId", { required: true, type: Number });
  const dayTypeId = defineModel("dayTypeId", { required: true, type: Number });
  const dateFrom = defineModel("dateFrom", { required: true, type: Date });
  const dateTo = defineModel("dateTo", { required: true, type: Date });
  const year = defineModel("year", { required: true, type: Number });
  const { errors = {} } = defineProps<{
    errors: any;
  }>();

 
</script>
<template>
  <div class="kt-section kt-section--first">
    <div class="kt-section__body">
      <h3 class="kt-section__title kt-section__title-lg">
        
      </h3>
    </div>
  </div>

  <div class="kt-section">
    <div class="kt-section__body">
      <h3 class="kt-section__title kt-section__title-lg">Pick a date:</h3>
      <!-- Tuka kalendaro -->
    </div>
  </div>
</template>
