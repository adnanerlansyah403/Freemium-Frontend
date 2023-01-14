/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: "class",
  theme: {
    container: {
    },
    screens: {
      'xs': '480px',
      'sm': '576px',
      'md': '768px',
      'lg': '992px',
      'xl': '1170px',
    },
    colors: {
      'white': '#ffffff',
      'black': '#000000',
      'primary': '#7C000B',
      'gray-primary': '#7A7A7A',
      'gray-secondary': '#8B8585',
      'gray-third': '#D9D9D9',
      'slate-primary': '#2F2E41',
      'slate-secondary': '#3F3D56',
      'slate-third': '#64748b',
      'slate-fourth': '#94a3b8',
    },
    fontSize: {
      xs: '12px',
      sm: '14px',
      base: '18px',
      md: '24px',
      lg: '32px',
      xl: '48px',
      '2xl': '72px',
    },
    fontFamily: {
      poppins: ['Poppins', 'sans-serif'],
      iceberg: ['Iceberg', 'sans-serif'],
    },
    extend: {
      borderRadius: {
        'circle': '50%',
        'pill': '50px',
        'primary': '10px',
        'secondary': '8px'
      },
      boxShadow: {
        'primary': '0px_0px_4px_rgba(0,0,0,0.25)',
      }
    }
  },
  plugins: [],
}