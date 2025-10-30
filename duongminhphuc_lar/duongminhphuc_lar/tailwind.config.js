/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue"
  ],

    plugins: [
      require('@tailwindcss/typography'),
    ],
  theme: {
    extend: {},
  },
  plugins: [],
}

