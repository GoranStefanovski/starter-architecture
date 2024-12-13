<script setup>
  import { DashLink } from "@starter-core/dash-ui/src";
  import { useOnClickOutside } from "@starter-core/dash-ui/src/composables";
  import {
    IconUser,
    IconMail,
    IconTerminal,
    IconPuzzle,
  } from "@starter-core/icons";
  import { ref } from "vue";
  import HeaderUserBarListItem from "./HeaderUserBarListItem.vue";
  import useAuthComp from "@/composables/useAuthComp";
  import "./HeaderUserBar.scss";

  const { logout, user } = useAuthComp();
  const isDropdownVisible = ref(false);
  const dropdownRef = ref();

  const toggleDropdown = () =>
    (isDropdownVisible.value = !isDropdownVisible.value);

  useOnClickOutside(dropdownRef, () => {
    if (isDropdownVisible.value) {
      toggleDropdown();
    }
  });
</script>
<template>
  <div
    class="kt-header__topbar-item kt-header__topbar-item--user header-user-bar"
  >
    <a
      class="kt-header__topbar-wrapper"
      @click.prevent="toggleDropdown"
      ref="dropdownRef"
    >
      <div class="kt-header__topbar-user">
        <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
        <span class="kt-header__topbar-username kt-hidden-mobile">{{
          user.first_name
        }}</span>
        <img class="kt-hidden" alt="Pic" src="" />

        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
        <span
          class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"
          >{{ user.first_name.charAt(0) }}</span
        >
      </div>
      <div
        class="header-user-bar__dropdown dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl"
        :class="{
          show: isDropdownVisible,
        }"
      >
        <!--begin: Head -->
        <div
          class="header-user-bar__user-card kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
        >
          <div class="kt-user-card__avatar">
            <img class="kt-hidden" alt="Pic" src="" />

            <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
            <span
              class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success"
              >{{ user.first_name.charAt(0) }}</span
            >
          </div>
          <div class="kt-user-card__name">
            {{ user.first_name }}
          </div>
          <div v-if="user.role === 1" class="kt-user-card__badge">
            <span class="btn btn-success btn-sm btn-bold btn-font-md"
              >23 requests</span
            >
          </div>
        </div>

        <!--end: Head -->

        <!--begin: Navigation -->
        <div class="kt-notification">
          <HeaderUserBarListItem
            v-if="user.role === 1"
            :icon="IconUser"
            :to="{ name: 'myprofile' }"
            title="My Profile"
            subtitle="Account settings and more"
          />
          <div class="kt-notification__custom kt-space-between">
            <a
              @click.prevent="logout"
              class="btn btn-label btn-label-brand btn-sm btn-bold"
              >Sign Out</a
            >
          </div>
        </div>

        <!--end: Navigation -->
      </div>
    </a>
  </div>
</template>
