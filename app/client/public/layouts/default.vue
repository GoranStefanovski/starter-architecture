<template>
  <div class="default-layout">
    <Header></Header>

    <div style="padding-top: 125px;" class="container body text-center">
      <h1 class="text-4xl font-bold mb-2">Welcome to BeAt</h1>
      <h2 class="text-xl text-gray-600 mb-8">Easiest way to find your perfect location with your perfect music</h2>

      <!-- <button class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-full mb-12">
        Explore Now
      </button> -->
        <br>
        <br>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left mb-4">
        <!-- Genres -->
        <div>
          <h3 class="text-2xl font-semibold mb-2">Our Genres</h3>
          <div class="flex flex-wrap gap-3">
            <span class="border border-purple-500 px-4 py-2 rounded-md">Pop</span>
            <span class="border border-purple-500 px-4 py-2 rounded-md">Rock</span>
            <span class="border border-purple-500 px-4 py-2 rounded-md">Jazz</span>
            <span class="border border-purple-500 px-4 py-2 rounded-md">Hip-Hop</span>
            <span class="border border-purple-500 px-4 py-2 rounded-md">EDM</span>
            <span class="border border-purple-500 px-4 py-2 rounded-md">Techno</span>
          </div>
        </div>
        <br>
        <br>
        <!-- Venues -->
        <div>
          <h3 class="text-2xl font-semibold mb-2">Our Locations</h3>
          <div class="flex flex-wrap gap-3">
            <span class="border border-purple-500 px-4 py-2 rounded-md">Nightclub</span>
            <span class="border border-purple-500 px-4 py-2 rounded-md">Bar</span>
            <span class="border border-purple-500 px-4 py-2 rounded-md">Concert Hall</span>
            <span class="border border-purple-500 px-4 py-2 rounded-md">Restaurant</span>
            <span class="border border-purple-500 px-4 py-2 rounded-md">Lounge</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  max-width: 960px;
  margin: 0 auto;
  padding: 1rem;
}
span {
  display: inline-block;
  padding: 8px 16px;
  border: 1px solid #9333ea;
  border-radius: 8px;
  margin: 5px;
}
button {
  background-color: #9333ea;
  color: white;
  padding: 12px 24px;
  border-radius: 9999px;
  margin-bottom: 2rem;
}
</style>
