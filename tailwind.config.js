const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [],
    darkMode: false, // or 'media' or 'class'
    theme: {
      extend: {
        fontFamily: {
          sans: ['Inter var', ...defaultTheme.fontFamily.sans],
        },
      },
    },
    variants: {
      extend: {},
      fill: ['hover', 'focus'], // this line does the trick
    },
    plugins: [
      require('@tailwindcss/typography'),
      require('@tailwindcss/forms'),
    ],
  }
