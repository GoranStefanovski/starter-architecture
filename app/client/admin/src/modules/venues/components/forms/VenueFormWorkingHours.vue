<script lang="ts" setup>
  import VueDatePicker from '@vuepic/vue-datepicker';
  import { useI18n } from 'vue-i18n';
  import type { WorkingHour, WorkingHourDatePicker } from '@/modules/venues/types';
  import { FormDropdown, FormInput } from '@starter-core/dash-ui/src';
  import '@vuepic/vue-datepicker/dist/main.css';
  import { onMounted } from 'vue';

  const { t } = useI18n();

  const { errors = {} } = defineProps<{
    errors: any;
  }>();
  const working_hours = defineModel<WorkingHour[]>('working_hours');
</script>
<template>
  <div>
    <div v-for="(hour, index) in working_hours" :key="hour.day_of_week">
      <div class="day-label">
        {{ t(`venues.working_hours.${hour.day_of_week}`) }}
      </div>

      <VueDatePicker
        :model-value="hour.opens_at"
        @update:model-value="
          (val: WorkingHourDatePicker) => {
            hour.opens_at = val;
          }
        "
        time-picker
        :enable-time-picker="true"
        :is24="true"
        :format="'HH:mm'"
        :placeholder="t('venues.working_hours.opens_at')"
      />

      <VueDatePicker
        :model-value="hour.closes_at"
        @update:model-value="
          (val: WorkingHourDatePicker) => {
            hour.closes_at = val;
          }
        "
        time-picker
        :enable-time-picker="true"
        :is24="true"
        :format="'HH:mm'"
        :placeholder="t('venues.working_hours.closes_at')"
      />

      <form-dropdown
        v-model="hour.is_closed"
        :id="`${index}`"
        :options="[
          { name: t('venues.working_hours.opened'), id: true },
          { name: t('venues.working_hours.closed'), id: false },
        ]"
      />
    </div>
  </div>
</template>
