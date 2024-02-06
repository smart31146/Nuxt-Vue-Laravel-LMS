/** @type {import('tailwindcss').Config} */
const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");
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
  darkMode: 'class',
  content: [],
  theme: {
    extend: {},
    backgroundColor: theme => ({
      ...theme('colors'),
      'primary': '#2e0249',
      'secondary': '#ffed4a',
      'danger': '#e3342f',
     })
   }
  ,
  plugins: [
    require('tw-elements/dist/plugin.cjs'), 
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
    require('flowbite/plugin')
  ],

}

