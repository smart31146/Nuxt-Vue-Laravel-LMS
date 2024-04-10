// /** @type {import('tailwindcss').Config} */
// const defaultTheme = require("tailwindcss/defaultTheme");
// const colors = require("tailwindcss/colors");
const colors = require('tailwindcss/colors')
const animate = require('tailwindcss-animated')
const plugin = require('tailwindcss/plugin')
module.exports = {
  content: [
    './components/**/*.{js,vue,ts}',
    './components/**/**/*.{js,vue,ts}',
    './layouts/**/*.vue',
    './layouts/**/**/*.vue',
    './pages/**/*.vue',
    './pages/**/**/*.vue',
    './plugins/**/*.{js,ts}',
    './nuxt.config.{js,ts}',
    './app.vue',
    './node_modules/tw-elements/dist/js/**/*.js',
    './node_modules/flowbite/**/*.{js,ts}'
  ],
  presets: [],
  media: false,
  theme: {
    extend: {
      colors: {
        weekGray: '#F4E7E7',
        customPink: '#7C1956',
        inputBackground: '#EAE7E7',
        lineColor: "#908888",
        titleColor: "#3C3939",
        customBlue: "#3631BE",
        customBlue2: "#A7C7EB",
        inputBorder: "#707070",
        adminNormalColor: "#08690F",
        adminNormalColor2: "#93E899",
        textBackgroundColor: "#625D60"
      },
    },
 
   }
  ,
  plugins: [
    plugin(function({ addUtilities }) {
      const newUtilities = {
        '.aspect-16-12': {
          'aspect-ratio': '16/12',
        },
        
      }

      addUtilities(newUtilities)
    }),
    animate],

}

