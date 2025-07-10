<script setup lang="ts">
  import { computed } from "vue";
  import type { FormDropdownProps } from "../types";
  import FormGroup from "../FormGroup/FormGroup.vue";
  import "./FormDropdown.scss";

  const { label, id, isInline, errors, isDisabled, options } =
    defineProps<FormDropdownProps>();

  // @ts-ignore
  const model = defineModel({
    required: true,
    type: [String, Number], // 👈 Allow both String and Number for user_id
  });

  // Check if current value is in options
  const hasDefaultOption = computed(() =>
    !options.some((option) => String(option.id) === String(model.value))
  );
</script>

<template>
  <form-group :is-inline="isInline" class-name="form-dropdown" :id="id">
    <template #label>
      {{ label }}
    </template>

    <template #input>
      <select
        :id="id"
        :name="id"
        :class="[
          'form-dropdown__input',
          { 'form-dropdown__input--error': errors?.length },
        ]"
        :disabled="isDisabled"
        v-model="model"
      >
        <option style="color: black;" v-if="hasDefaultOption" value="">
          {{ label || 'Select an Option' }}
        </option>
        <option
          style="color: black;"
          v-for="option in options"
          :key="option.id"
          :value="option.id"
          :disabled="option.isDisabled"
        >
          <!-- 👇 Show full user info -->
          {{ option.label || option.name || `User #${option.id}` }}
        </option>
      </select>

      <div
        v-if="errors?.length"
        class="form-dropdown__error"
      >
        <span v-for="error in errors" :key="error">
          {{ error }}
        </span>
      </div>
    </template>
  </form-group>
</template>
