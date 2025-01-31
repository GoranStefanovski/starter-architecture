<script lang="ts" setup>
  import { IconMail } from "@starter-core/icons";
  import { useI18n } from "vue-i18n";
  import { FormInput, FormSwitch } from "@starter-core/dash-ui/src";

  const { t } = useI18n();
  const userId = defineModel("user_id", { required: true, type: Number });
  const leaveTypeId = defineModel("leave_type_id", { required: true, type: Number });
  const startDate = defineModel("start_date", { required: true, type: Date });
  const endDate = defineModel("end_date", { required: true, type: Date });
  const status = defineModel("status", { required: true, type: String });
  const reason = defineModel("reason", { required: true, type: String });
  const requestTo = defineModel("request_to", { required: true, type: String });
  const approvedBy = defineModel("approved_by", { required: true, type: String });
</script>
<template>
<div class="kt-section kt-section--first">
    <div class="kt-section__body">
      <h3 class="kt-section__title kt-section__title-lg">
        {{ t("leaveRequests.leaveRequest_status") }}:
      </h3>
    </div>
  </div>

  <div
    class="kt-separator kt-separator--border-dashed kt-separator--space-lg"
  ></div>

  <div class="kt-section">
    <div class="kt-section__body">
      <h3 class="kt-section__title kt-section__title-lg">Request:</h3>
      <form-input
        v-model="status"
        name="status"
        :label="t('leaveRequests.status.label')"
        is-inline
      />
      <form-input
        v-model="reason"
        name="reason"
        :label="t('leaveRequests.reason.label')"
        is-inline
      />
    </div>
  </div>
</template>
