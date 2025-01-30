<script setup lang="ts">
  import { inject } from "vue";
  import { isMenuMinimizedKey } from "../constants";

  import './MenuSection.scss';

  const isMinimized = inject(isMenuMinimizedKey);
</script>
<template>
  <li :class="['kt-menu__section', {
  }]">
    <h4 v-if="!isMinimized" class="kt-menu__section-text">Main</h4>
    <i :class="['kt-menu__section-icon', 'flaticon-more-v2', {
    }]" />
  </li>
</template>
