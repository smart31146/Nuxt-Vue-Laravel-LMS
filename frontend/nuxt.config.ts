// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    devtools: { enabled: true },
    css: [
        '/assets/scss/style.css',
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
    modules: '@nuxtjs/tailwindcss',
    build: {
        postcss: {
            plugins: {
              tailwindcss: {},
              autoprefixer: {},
              'postcss-import': true,
            },
          },
        rollupOptions: {
          external: ['vuex'],
        },
      },
    buildModules: [
        '@nuxt/typescript-build',
        '@nuxtjs/tailwindcss'
    ],
    tailwindcss: {
        exposeConfig: true,
        jit: true,
        viewer: false
      }

})

