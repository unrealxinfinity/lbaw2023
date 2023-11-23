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
      green: '#008000'
    },
    fontFamily: {
      sans: ['Graphik', 'sans-serif'],
      serif: ['Merriweather', 'serif'],
      roboto: ['Roboto', 'sans-serif'],
      minecraft: ['Minecraft', 'sans-serif']
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
        '.panel': {
          display: 'flex',
          overflow: 'auto',
          justifyContent: 'flex-start',
        },
        '.container': {
          display: 'flex',
          flexDirection: 'column',
          justifyContent: 'flex-end',
          minWidth: '15em',
          maxWidth: '20em',
          width: 'auto',
          minHeight: '5em',
          maxHeight: '11em',
          height: 'auto',
          margin: '0.5em 1em',
          backgroundColor: 'rgba(169, 169, 169, 0.5)',
          borderRadius: '5px',
        },
        '.container-title': {
          fontSize: '1.5rem',
          fontFamily: 'roboto',
          letterSpacing: '.01em',
          padding: '0.5em 1em 0em', 
        },
        '.container-desc': {
          overflow: 'hidden',
          padding: '0em 1em 0.5em',
        },
        '.container-desc h4': {
          transform: 'translateY(0)',
          transition: '2s',
          wordWrap: 'break-word',
          overflowWrap: 'break-word',
        },
        '.container-desc:hover h4': {
          transform: 'translateY(calc(2em - 100%))',
        },
      }
      addComponents(myComponents)
    },
    function({ addBase }) {
      const myBases = {
        'h2': {
          borderRadius: '5px',
          margin: '10px 10px',
          color: 'green',
          fontSize: '2.5rem',
          fontFamily: 'roboto',
          letterSpacing: '.01em',
        },
      }
      addBase(myBases)
    }
  ],
}
