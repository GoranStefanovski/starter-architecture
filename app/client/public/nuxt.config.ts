// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: {
    enabled: true
  },

  css: [
    "~/assets/main.scss",
    "~/node_modules/bootstrap/dist/css/bootstrap.min.css"
  ],

  modules: [
    '@nuxt/image',
  ],

  image: {
    dir: 'public/images',
    screens: {
      'xs': 320,
      'sm': 640,
      'md': 768,
      'lg': 1024,
      'xl': 1280,
      'xxl': 1536
    },
  },

  vite: {
    server: {
      hmr: {
        host: '0.0.0.0',
        clientPort: 3030,
        protocol: 'ws',
      }
    }
  },

  compatibilityDate: '2024-10-14'
})
