<script lang="ts" setup>
  import { DashButton, DashLink } from "@starter-core/dash-ui/src";
  import { IconSave, IconArrowleft } from "@starter-core/icons";
  import { useForm } from "vee-validate";
  import { watch, computed } from "vue";
  import { useI18n } from "vue-i18n";
  import { useRoute } from "vue-router";
  import {
    TabbedContent,
    TabbedContentTab,
    PageWrapper,
    PAGE_WRAPPER_SLOTS,
    SubheaderTitle,
  } from "../../../components";
  import { CalendarFormBasicInfoTab, UserFormPasswordTab } from "../components";
  import { useVacationDaysForm } from "../composables";
  import type { VacationDayFormItem } from "../types";

  const { t } = useI18n();
  const basicInfoLabeel = t("vacationDays.basic.information");
  const route = useRoute();
  const vacationDayId = Number(route.params.vacationDayId);

  const validationSchema = {
    last_name(value: string) {
      if (value?.length >= 5) return true;
      return "Name needs to be at least 5 characters.";
    },
  };

  const {
    isLoading,
    data: formData,
    requestVacationDay,
  } = useVacationDaysForm(vacationDayId);

  const { handleSubmit, errors, setValues, defineField } =
    useForm<VacationDayFormItem>({
      validationSchema,
    });

  const submitHandler = handleSubmit((values) => {
      requestVacationDay(values);
  });


  watch(() => {
    if (formData.value) {
      setValues({
        id: formData.value.id,
        user_id: formData.value.user_id,
        day_type_id: formData.value.day_type_id,
        date_from: formData.value.date_from,
        date_to: formData.value.date_to,
        year: formData.value.year,
      });
    }
  }, [formData]);

  const [userId] = defineField("user_id");
  const [dayTypeId] = defineField("day_type_id");
  const [dateFrom] = defineField("date_from");
  const [dateTo] = defineField("date_to");
  const [year] = defineField("year");
</script>

<template>
  <PageWrapper>
    <template #[PAGE_WRAPPER_SLOTS.subheaderMain]>
      <SubheaderTitle
        title='Request A Vacation Day'
      />
    </template>
    <template #[PAGE_WRAPPER_SLOTS.subheaderToolbox]>
      <DashLink to="/admin/vacationDays" :icon="IconArrowleft" theme="clean">
        {{ t("buttons.back") }}
      </DashLink>
      <DashButton
        type="submit"
        :loading="isLoading"
        @click="submitHandler"
      >
        Submit
      </DashButton>
    </template>
    <form
      autocomplete="off"
      enctype="multipart/form-data"
      @submit.prevent="submitHandler"
    >
      <TabbedContent :isLoading="isLoading">
        <TabbedContentTab :label="basicInfoLabeel" id="basic-info">
          <CalendarFormBasicInfoTab
            v-model:userId="userId"
            v-model:dayTypeId="dayTypeId"
            v-model:dateFrom="dateFrom"
            v-model:dateTo="dateTo"
            v-model:year="year"
            :errors="errors"
          />
        </TabbedContentTab>
      </TabbedContent>
    </form>
  </PageWrapper>
</template>
