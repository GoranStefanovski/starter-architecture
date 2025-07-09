<script lang="ts" setup>
  import { reactive } from 'vue';
  import { useI18n } from 'vue-i18n';
  import { FormInput, FormSwitch } from '@starter-core/dash-ui/src';

  const { t } = useI18n();

  // Two-way binding for working_hours
  const workingHours = defineModel('working_hours', { required: true, type: Object });

  // Days of the week
  const days = [
    { key: 'monday', label: t('venues.working_hours.monday') },
    { key: 'tuesday', label: t('venues.working_hours.tuesday') },
    { key: 'wednesday', label: t('venues.working_hours.wednesday') },
    { key: 'thursday', label: t('venues.working_hours.thursday') },
    { key: 'friday', label: t('venues.working_hours.friday') },
    { key: 'saturday', label: t('venues.working_hours.saturday') },
    { key: 'sunday', label: t('venues.working_hours.sunday') },
  ];

  // Default structure for a day
  const defaultDay = () => ({ open: false, from: null, to: null });

  // Initialize working_hours if not set
  const defaultWorkingHours = reactive({
    monday: { open: false, from: null, to: null },
    tuesday: { open: false, from: null, to: null },
    wednesday: { open: false, from: null, to: null },
    thursday: { open: false, from: null, to: null },
    friday: { open: false, from: null, to: null },
    saturday: { open: false, from: null, to: null },
    sunday: { open: false, from: null, to: null },
  });

  // Use fallback if parent didn't send working_hours
  if (!workingHours.value) {
    workingHours.value = defaultWorkingHours;
  }
</script>

<template>
  <div class="venue-working-hours">
    <div v-for="day in days" :key="day.key" class="form-group form-input form-group--inline">
      <div class="form-group__column form-group__column--left form-group__column--inline">
        <label class="form-group__label">{{ day.label }}</label>
      </div>

      <div class="form-group__column form-group__column--left form-group__column--inline">
        <form-switch
          v-model="workingHours[day.key].open"
          :id="`working-hours-switch-${day.key}`"
          theme="success"
          type="outline"
          :label="t('venues.working_hours.status')"
          :helper-text="workingHours[day.key].open ? t('venues.working_hours.open') : t('venues.working_hours.closed')"
        />
      </div>

      <div
        v-if="workingHours[day.key].open"
        class="form-group__column form-group__column--left form-group__column--inline time-fields"
      >
        <form-input
          v-model="workingHours[day.key].from"
          name="from"
          type="time"
          :label="t('venues.working_hours.from')"
          is-inline
        />
        <form-input v-model="workingHours[day.key].to" name="to" type="time" :label="t('venues.working_hours.to')" is-inline />
      </div>
    </div>
  </div>
</template>

<style scoped>
  .venue-working-hours {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
  .time-fields {
    display: flex;
    gap: 1rem;
  }
</style>
