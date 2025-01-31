<script lang="ts" setup>
  import { IconSave, IconArrowleft } from "@starter-core/icons";
  import { useAuth } from "@websanova/vue-auth/src/v3.js";
  import { useForm } from "vee-validate";
  import { watch, computed, onMounted } from "vue";
  import { useI18n } from "vue-i18n";
  import { useRoute } from "vue-router";
  import {
    TabbedContent,
    TabbedContentTab,
    PageWrapper,
    PAGE_WRAPPER_SLOTS,
    SubheaderTitle,
  } from "../../../components";
  import { LeaveRequestsFormBasicInfoTab } from "../components";
  import { useLeaveRequestsForm } from "../composables";
  import type { LeaveRequestFormItem } from "../types";
  import { DashButton, DashLink } from "@starter-core/dash-ui/src";

  const { t } = useI18n();
  const basicInfoLabeel = t("users.basic.information");
  const route = useRoute();
  const isEditPage = computed(() => route.name == "edit.leave_request");
  const leaveRequestId = Number(route.params.leaveRequestId);

  const validationSchema = {
    reason(value: string) {
      if (value?.length >= 5) return true;
      return "Name needs to be at least 5 characters.";
    },
  };

  const auth = useAuth();

  const {
    isLoading,
    data: formData,
    createLeaveRequest,
    updateLeaveRequest,
  } = useLeaveRequestsForm(leaveRequestId);

  const { handleSubmit, setValues, defineField } =
    useForm<LeaveRequestFormItem>({
      validationSchema,
    });

  const submitHandler = handleSubmit((values) => {
    if (isEditPage.value) {
      updateLeaveRequest(values);
    } else {
      createLeaveRequest(values);
    }
  });

  onMounted(() => {
    const user = auth.user();
    if (user && user.id) {
      userId.value = user.id;
    }
  });
  const formatDate = (date: string | Date | null): string => {
    if (!date) return "";
    return new Date(date).toISOString().split("T")[0]; // Extracts only YYYY-MM-DD
  };

  watch(() => {
    if (formData.value) {
      setValues({
        id: formData.value.id,
        user_id: formData.value.user_id,
        leave_type_id: formData.value.leave_type_id,
        start_date: formatDate(formData.value.start_date),
        end_date: formatDate(formData.value.end_date),
        reason: formData.value.reason,
        request_to: formData.value.request_to,
      });
    }
  }, [formData]);

  const [userId] = defineField("user_id");
  const [leaveTypeId] = defineField("leave_type_id");
  const [startDate] = defineField("start_date");
  const [endDate] = defineField("end_date");
  const [reason] = defineField("reason");
  const [requestTo] = defineField("request_to");
</script>

<template>
  <PageWrapper>
    <template #[PAGE_WRAPPER_SLOTS.subheaderMain]>
      <SubheaderTitle
        title="Request"
      />
    </template>
    <template #[PAGE_WRAPPER_SLOTS.subheaderToolbox]>
      <DashLink to="/admin/leave_requests" :icon="IconArrowleft" theme="clean">
        {{ t("buttons.back") }}
      </DashLink>
      <DashButton
        type="submit"
        :icon="IconSave"
        :loading="isLoading"
        @click="submitHandler"
      >
        {{ t("buttons.save") }}
      </DashButton>
    </template>
    <form
      autocomplete="off"
      enctype="multipart/form-data"
      @submit.prevent="submitHandler"
    >
      <TabbedContent :isLoading="isLoading">
        <TabbedContentTab :label="basicInfoLabeel" id="basic-info">
          <LeaveRequestsFormBasicInfoTab
            v-model:userId="userId"
            v-model:leaveTypeId="leaveTypeId"
            v-model:startDate="startDate"
            v-model:endDate="endDate"
            v-model:reason="reason"
            v-model:requestTo="requestTo"
          />
        </TabbedContentTab>
      </TabbedContent>
    </form>
  </PageWrapper>
</template>
