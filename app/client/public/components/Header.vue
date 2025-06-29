<script lang="ts" setup>
import "./Header.css";
</script>
<template>
  <nav>
    <div class="wrapper">
      <div style="width: 150px;" class="logo"><NuxtImg style="width: 100%;" src="/beat_logo.svg" /></div>
      <input type="radio" name="slider" id="menu-btn" />
      <input type="radio" name="slider" id="close-btn" />
      <ul class="nav-links">
        <li><nuxt-link style="color: black;" to="mailto:tevidma@gmail.com">Contact Us</nuxt-link></li>
      </ul>
      <label for="menu-btn" class="btn menu-btn"
        ><i class="fas fa-bars"></i
      ></label>
    </div>
  </nav>
</template>
