<script setup lang="ts">
import { computed, ref } from "vue";
import type { FormDropdownProps } from "../types";
import FormGroup from "../FormGroup/FormGroup.vue";
import "./FormMultiSelect.scss";

const { label, id, isInline, errors, isDisabled, options } =
  defineProps<FormDropdownProps>();

const model = defineModel<string[]>({ required: true });
const isOpen = ref(false);

const toggleDropdown = () => {
  if (!isDisabled) isOpen.value = !isOpen.value;
};

const selectedOptions = computed(() =>
  options.filter(option => (model.value ?? []).includes(option.id))
);

const availableOptions = computed(() =>
  options.filter(option => !(model.value ?? []).includes(option.id))
);
const select = (id: string) => {
  model.value = [...model.value, id];
};

const remove = (id: string) => {
  model.value = model.value.filter(v => String(v) !== String(id));
};

</script>
<template>
  <form-group :is-inline="isInline" class-name="form-dropdown" :id="id">
    <template v-slot:label>
      {{ label }}
    </template>

    <template v-slot:input>
      <div class="form-dropdown--multi__wrapper" @click="toggleDropdown">
        <div class="form-dropdown--multi__tag" v-for="tag in selectedOptions" :key="tag.id">
          {{ tag.name }}
          <span class="form-dropdown--multi__tag-remove" @click.stop="remove(tag.id)">×</span>
        </div>

        <input
          class="form-dropdown--multi__input"
          placeholder="Select..."
          readonly
        />
      </div>

      <div v-if="isOpen" class="form-dropdown--multi__dropdown">
        <div
          v-for="option in availableOptions"
          :key="option.id"
          class="form-dropdown--multi__option"
          @click.stop="select(option.id)"
        >
          {{ option.name }}
        </div>
      </div>

      <div v-if="errors?.length" class="form-dropdown__error">
        <span v-for="error in errors" :key="error">{{ error }}</span>
      </div>
    </template>
  </form-group>
</template>


