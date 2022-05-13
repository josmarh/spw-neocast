module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{html,vue,js}",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('flowbite/plugin')
  ],
}
