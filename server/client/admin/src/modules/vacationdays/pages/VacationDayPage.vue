<script lang="ts" setup>
  import { DashButton, DashLink } from "@starter-core/dash-ui/src";
  import { IconSave, IconArrowleft } from "@starter-core/icons";
  import { useForm } from "vee-validate";
  import { watch, computed, ref } from "vue";
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
    dayTypes,
    handlers
  } = useVacationDaysForm(vacationDayId);

  const selectedDayTypeId = ref<number | null>(null);
  const selectedHandlerId = ref<number | null>(null);

  const { handleSubmit, errors, setValues, defineField } =
    useForm<VacationDayFormItem>({
      validationSchema,
    });
  
  const submitHandler = async () => {
    const testValues = {
      id: vacationDayId || 0,
      user_id: 1, // Replace with a valid user ID
      handler_id: 1,
      day_type_id: 1, // Example day type ID
      date_from: new Date('2024-01-01'), // Example date
      date_to: new Date("2024-01-05"), // Example date
      year: 2024, // Example year
    };

    try {
      const response = await requestVacationDay(testValues);
      console.log("API Response:", response);
    } catch (error) {
      console.error("API Error:", error);
    }
  };

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
      <SubheaderTitle title="Request A Vacation Day" />
    </template>
    <template #[PAGE_WRAPPER_SLOTS.subheaderToolbox]>
      <DashLink to="/admin/vacationDays" :icon="IconArrowleft" theme="clean">
        {{ t("buttons.back") }}
      </DashLink>

      <!-- Dropdown for Vacation Day Type -->
      <select v-model="selectedDayTypeId" class="dropdown">
        <option disabled value="">Select Vacation Day Type</option>
        <option v-for="type in dayTypes" :key="type.id" :value="type.id">
          {{ type.name }}
        </option>
      </select>

      <!-- Dropdown for Handler -->
      <select v-model="selectedHandlerId" class="dropdown">
        <option disabled value="">Select Handler</option>
        <option v-for="handler in handlers" :key="handler.id" :value="handler.id">
          {{ handler.first_name + ' ' + handler.last_name }}
        </option>
      </select>

      <DashButton :loading="isLoading" @click="submitHandler">
        Submit
      </DashButton>
    </template>
  </PageWrapper>
</template>


