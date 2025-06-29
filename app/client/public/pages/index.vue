<script lang="ts" setup>
useHead({
  title: 'BeAt'
})
</script>

<template>
  <Jumbotron>
    <div class="page-wrapper">
      <!-- Coming Soon Message -->
      <div class="coming-soon">
        <h4>Coming Soon...</h4>
      </div>

      <!-- Main Section -->
      <div class="content">
        <!-- Left: Banner Image -->
        <div class="left">
          <NuxtImg src="/homepage_banner.png" alt="BeAt Banner" class="banner" />
        </div>

        <!-- Right: Textual Content -->
        <div class="right">
          <h1 class="headline">Discover Events & Venues with BeAt</h1>
          <h2 class="subtitle">Your personalized nightlife experience starts here</h2>
          <h3 class="subheading">Browse by Genre or Location</h3>
          <h4 class="cta">Be an early insider — unlock exclusive venues and events.</h4>
          <h5><NuxtLink to="mailto:tevidma@gmail.com" class="md-min-hidden" style="color: white;">contact@beat.com</NuxtLink></h5>
        </div>
      </div>
    </div>
  </Jumbotron>
</template>

<style scoped>
.page-wrapper {
  min-height: 100vh;
  color: #FBF5DD;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 3rem 1rem;
}

.coming-soon {
  text-align: center;
  margin-bottom: 4rem;

  @media (max-width: 576px) {
    margin-bottom: 2rem;
    font-size: 2rem;
    margin-top: -25%;
  }
}

.coming-soon h4 {
  font-size: 4.6rem;
  font-weight: 700;
  color: #FBF5DD;
}

.content {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
  gap: 3rem;
}

.left {
  flex: 1 1 400px;
  text-align: center;
}

.banner {
  max-width: 100%;
  max-height: 450px;
  border-radius: 1rem;

  @media (max-width: 576px) {
    opacity: 0.7;
  }
}

.right {
  flex: 1 1 400px;
  display: flex;
  flex-direction: column;
  gap: 1.2rem;

  @media (max-width: 576px) {
    position: absolute;
    margin-top: 25%;
    z-index: 9999;
    padding: 20px;
    gap: 0rem;
  }
}

.headline {
  font-size: 3.5rem;
  font-weight: 700;
  color: #FBF5DD;

  @media (max-width: 576px) {
    font-size: 3rem;
  }
}

.subtitle {
  font-size: 2.25rem;
  font-weight: 500;
  color: #DDA853;
}

.subheading {
  font-size: 1.75rem;
  font-weight: 600;
  color: #FBF5DD;
}

.cta {
  font-size: 1rem;
  color: #DDA853;
  margin-top: 1rem;
}

.md-min-hidden {
  color: white;
  @media (min-width: 576px) {
    display: none;
  }
}
</style>
