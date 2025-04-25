/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./**/*.php",
      "./assets/js/**/*.js"
    ],
    theme: {
      extend: {
        colors: {
          'podcast-purple': '#8B5CF6',
          'podcast-deep-purple': '#7E69AB',
          'podcast-dark': '#1A1F2C',
          'podcast-light': '#F1F0FB',
          'podcast-gray': '#8E9196',
        },
      },
    },
    plugins: [],
  }
  