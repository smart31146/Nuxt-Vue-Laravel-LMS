// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    devtools: { enabled: true },
    css: [
        '@/assets/scss/style.scss',
        '@/assets/scss/style.css',
    ],
    ssr: false,
    runtimeConfig:
    {
        public:
        {
            apiUrl: process.env.API_URL,
            TINYMCE_API_KEY: process.env.TINYMCE_API_KEY,
        }
    },
    modules: ['@vueuse/nuxt'],
    build: {
        rollupOptions: {
          external: ['vuex'],
        },
      },
})

