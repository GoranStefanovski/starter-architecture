<script setup lang="ts">
  import { ref } from "vue";
  import NavMenu from "../../../../src/components/Menu/NavMenu/NavMenu.vue";
  import { navMenu, briefcaseIcon } from "./constants/data";

  const props = defineProps({
    isMinimizedMenu: {
      type: Boolean,
      default: false
    }
  })

  const isHover = ref(false);
  const mouseOverHandler = () => {
    isHover.value = true;
  };
  const mouseLeaveHandler = () => {
    isHover.value = false;
  };
</script>
<template>
  <div @mouseover="mouseOverHandler" @mouseleave="mouseLeaveHandler">
    <div :class="['aside']">
      <NavMenu
        :items="navMenu.map((item) => ({ ...item, icon: briefcaseIcon }))"
        :style="'icons'"
        type="vertical"
        theme="classic"
      />
    </div>
  </div>
</template>
<style lang="scss">
  @import "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css";
  .aside {
    width: 265px;
    transition: all 0.3s ease;

    &--minimized {
      width: 70px;
    }
  }
</style>
