/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],
  theme: {
    extend: {
      colors: {
        blue: {
          separator: '#8FB6D5',
          small: '#5883A6',
          dark: '#0A182E',
          body: '#151A42',
          block: '#232b52',
          custom: '#0F4274',
          custom1: '#165DA3',
        },
        orange: {
          custom: '#FF715B',
        },
        gray: {
          custom: '#B5C4D2',
          dark: '#C4C6D0',
        },
        yellow: {
          custom: '#F1E76C',
        },
        red: {
          custom: '#F14762',
          main: '#F04E51',
        },
        teal: {
          custom: '#2ACCB5',
          dark: '#218791',
        },
        green: {
          custom: '#9DC233',
        }
      },
      fontFamily: {
        roboto: ['Roboto', 'sans-serif'],
        sans: [
          'ui-sans-serif',
          'system-ui',
          '-apple-system',
          'BlinkMacSystemFont',
          '"Segoe UI"',
          'Roboto',
          '"Helvetica Neue"',
          'Arial',
          '"Noto Sans"',
          'sans-serif',
          '"Apple Color Emoji"',
          '"Segoe UI Emoji"',
          '"Segoe UI Symbol"',
          '"Noto Color Emoji"',
        ],
      },
    },
  },
  plugins: [
  ],
}
