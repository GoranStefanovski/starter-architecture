<script lang="ts" setup>
  import { onMounted } from 'vue';
  import type { PropType } from 'vue';
  import { useI18n } from 'vue-i18n';
  import { FormDropdown, FormInput } from '@starter-core/dash-ui/src';
  import type { FormDropdownOption } from '@starter-core/dash-ui/src/components/Form/types';

  const { t } = useI18n();
  const { ticketTypes } = defineProps<{
    ticketTypes: any[];
  }>();

  onMounted(async () => {});
</script>
<template>
  <div class="form-group form-input form-group--inline">
    <form-input v-model="ticket.price" name="name" :label="t('events.tickets.price')" is-inline />
    <form-input v-model="ticket.quantity" name="name" :label="t('events.tickets.quantity')" is-inline />
    <!--      <form-input v-model="tickets" name="tickets" :label="t('events.tickets.add')" is-inline />-->
    <form-dropdown
      id="country"
      v-model="ticket.type"
      name="country"
      :label="t('events.tickets.type')"
      :options="ticketTypes"
      is-inline
    />
  </div>
</template>
