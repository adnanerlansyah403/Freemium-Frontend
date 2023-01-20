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
      'gray-fourth': '#374151',
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
      bebasNeue: ['Bebas Neue', 'cursive'],
      neucha: ['Neucha', 'cursive'],
      comic: ['Comic Neue', 'cursive'],
      quickSand: ['Quicksand', 'sans-serif'],
    },
    extend: {
      animation: {
        bounce5: 'bounce-5 1s ease-in-out linear',
        // waveSmooth: 'wave 1.5s infinite',
      },
      keyframes: {
        'bounce-5': {
          '0%': {
            transform: 'translateY(0)'
          },

          '10%': {
            transform: 'translateY(0)'
          },

          '30%': {
            transform: 'translateY(-100px)'
          },

          '50%': {
            transform: 'translateY(0)'
          },

          '57%': {
            transform: 'translateY(-7px)'
          },

          '64%': {
            transform: 'translateY(0)'
          },

          '100%': {
            transform: 'translateY(0)'
          },
        },
        'wave': {
          '0%': {
            transform: 'translateY(0)'
          },
          '50%': {
            transform: 'translateY(-30px)'
          },
          '100%': {
            transform: 'translateY(0)'
          }
        }
      },
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