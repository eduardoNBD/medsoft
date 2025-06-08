/** @type {import('tailwindcss').Config} */
export default {
  content: [ 
    "./resources/**/*.blade.php", 
    "./config/menu.php",
    "./resources/**/*.js", 
  ],
  darkMode: "class",
  theme: {
    extend: {
      backgroundImage: {
        'login-aside': "url('../img/login.svg')",
        'usa': "url('../img/flags/us.svg')",
        'mex': "url('../img/flags/mx.svg')",
      }
    },
    screens: { 
      'xs': '530px',
      'sm': '758px',
      'md': '992px',
      'lg': '1240px',
    },
  },
  plugins: [],
}
