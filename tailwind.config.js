/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/views/**/*.blade.php",
    "./public/js/*.js",
  ],
  theme: {
    screens: {
      sm: '480px',
      md: '768px',
      lg: '976px',
      xl: '1440px',
    },
    colors: {
      white: '#ffffff',
      black: '#000000',
    },
    fontFamily: {
      sans: ['Graphik', 'sans-serif'],
      serif: ['Merriweather', 'serif'],
      roboto: ['Roboto', 'sans-serif'],
    },
    fontSize: {
      superBig: '3rem',
      superBigPhone: '1.5rem',
      big: '2rem',
      bigPhone: '1rem'
    },
    extend: {
      spacing: {
        '128': '32rem',
        '144': '36rem',
      },
      borderRadius: {
        '4xl': '2rem',
      },
      transitionProperty: {
        'width': 'width'
      },
      backgroundImage: {
        'mine': "url('/resources/img/dark.png')"
      }
    }
  },
  plugins: [
    function ({ addVariant }) {
      addVariant('child', '& > *');
    },
    function({ addComponents }) {
      const myComponents = {
        '.button': {
          backgroundColor: 'green',
          borderRadius: '5px',
          padding: '0.5em 2em',
          margin: '10px 10px',
          color: 'white',
          fontSize: '1rem'
          
        },
      }
      addComponents(myComponents)
    }
  ],
}
