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
  import { LeaveRequestsFormBasicInfoTab, LeaveRequestsFormApproveTab } from "../components";
  import { useLeaveRequestsForm } from "../composables";
  import type { LeaveRequestFormItem } from "../types";
  import { DashButton, DashLink } from "@starter-core/dash-ui/src";
  import { useRootStore } from "@/store/root";

  const { t } = useI18n();
  const basicInfoLabeel = t("users.basic.information");
  const route = useRoute();
  const isEditPage = computed(() => route.name == "edit.leave_request");
  const isApprovePage = computed(() => route.name == "approve.leave_request");
  const leaveRequestId = Number(route.params.leaveRequestId);
  const { setBackUrl } = useRootStore();

  const auth = useAuth();

  const {
    isLoading,
    data: formData,
    createLeaveRequest,
    updateLeaveRequest,
    approveLeaveRequest,
    declineLeaveRequest,
  } = useLeaveRequestsForm(leaveRequestId);

  const { handleSubmit, errors, setValues, defineField } =
    useForm<LeaveRequestFormItem>({
    });

  const submitHandler = handleSubmit((values) => {
    if (isEditPage.value) {
      updateLeaveRequest(values);
    } else {
      createLeaveRequest(values);
    }
  });

  const approve = handleSubmit((values) => {
      approveLeaveRequest(values);
  });

  const decline = handleSubmit((values) => {
      declineLeaveRequest(values);
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
        is_confirmed: formData.value.is_confirmed
      });
    }
  }, [formData]);

  const [userId] = defineField("user_id");
  const [leaveTypeId] = defineField("leave_type_id");
  const [startDate] = defineField("start_date");
  const [endDate] = defineField("end_date");
  const [reason] = defineField("reason");
  const [requestTo] = defineField("request_to");
  const [isConfirmed] = defineField("is_confirmed");
</script>

<template>
  <PageWrapper>
    <template #[PAGE_WRAPPER_SLOTS.subheaderMain]>
      <SubheaderTitle
        title="Request"
      />
    </template>
    <template v-if="!isApprovePage" #[PAGE_WRAPPER_SLOTS.subheaderToolbox]>
      <DashLink v-if="!isApprovePage" to="/admin/leave_requests" :icon="IconArrowleft" theme="clean">
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
        <TabbedContentTab v-if="!isApprovePage" :label="basicInfoLabeel" id="basic-info">
          <LeaveRequestsFormBasicInfoTab
            v-model:userId="userId"
            v-model:leaveTypeId="leaveTypeId"
            v-model:startDate="startDate"
            v-model:endDate="endDate"
            v-model:reason="reason"
            v-model:requestTo="requestTo"
            :errors="errors"
            :user="auth.user()"
          />
        </TabbedContentTab>
        <TabbedContentTab v-else :label="'Leave Request Confirmation'" id="basic-info">
          <LeaveRequestsFormApproveTab
            v-model:userId="userId"
            v-model:leaveTypeId="leaveTypeId"
            v-model:startDate="startDate"
            v-model:endDate="endDate"
            v-model:reason="reason"
            v-model:requestTo="requestTo"
            :user="auth.user()"
          />
        </TabbedContentTab>
        <div v-if="auth.user().id == requestTo">
          <div v-if="(isConfirmed == 0) && isApprovePage">
            <div v-if="!isLoading" class="confirmation_btn_wrapper">
              <span class="req_btn approve" @click="approve">
                Approve
              </span>
              <span class="req_btn decline" @click="decline">
                Decline
              </span>
            </div>
            <div v-else class="loading_wrapper">
              <span class="spinner"></span>
            </div>
          </div>
        </div>
      </TabbedContent>
    </form>
  </PageWrapper>
</template>
<style scoped lang="scss">
  .confirmation_btn_wrapper {
    display: flex;
  }
  .req_btn {
    color: white;
    font-size: 12px;
    font-weight: bold;
    padding: 10px 15px;

    &:hover{
      cursor: pointer;
    }
  }

  .approve {
    border-radius: 4px;
    background: #6c757d;
    color: white;
    margin-right: 8px;
    &:hover {
      background: #5a6268;
    }
  }

  .decline {
    border-radius: 4px;
    background: #d9534f;
    color: white;
  
    &:hover {
      background: #c9302c;
    }
  }

  .spinner {
    display: inline-block;
    width: 14px;
    height: 14px;
    border: 2px solid currentColor;
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
  }

  @keyframes spin {
    100% {
      transform: rotate(360deg);
    }
  }
</style>