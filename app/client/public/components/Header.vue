<script lang="ts" setup>
import "./Header.css";
</script>
<template>
  <nav>
    <div class="wrapper">
      <div class="logo"><NuxtImg src="/logo_white.svg" /></div>
      <input type="radio" name="slider" id="menu-btn" />
      <input type="radio" name="slider" id="close-btn" />
      <ul class="nav-links">
        <li><nuxt-link to="mailto:tevidma@gmail.com">Contact Us</nuxt-link></li>
      </ul>
      <label for="menu-btn" class="btn menu-btn"
        ><i class="fas fa-bars"></i
      ></label>
    </div>
  </nav>
</template>
