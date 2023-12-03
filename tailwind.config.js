/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/views/**/*.blade.php",
    "./public/js/*.js",
  ],
  theme: {
    screens: {
      sm: '480px',
      md: '780px',
      lg: '976px',
      xl: '1440px',
    },
    colors: {
      white: '#ffffff',
      black: '#000000',
      grey: '#5E716A',
      green: '#008000',
      red: '#FF0000',
    },
    fontFamily: {
      sans: ['Graphik', 'sans-serif'],
      serif: ['Merriweather', 'serif'],
      roboto: ['Roboto', 'sans-serif'],
      minecraft: ['Minecraft', 'sans-serif']
    },
    fontSize: {
      superBig: '2.5rem',
      superBigPhone: '1.2rem',
      big: '1.6rem',
      bigPhone: '1rem',
      medium: '0.8rem',
      mediumPhone: '0.6rem',
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
        'width': 'width',
        'height': 'height',
        'opacity': 'opacity',
      },
      transitionTimingFunction: {
        'ease': 'ease',
      },
      backgroundImage: {
        'mine': "url('/resources/img/dark.png')"
      },
      
    }
  },
  plugins: [
    function ({ addVariant }) {
      addVariant('child', '& > *');
    },
  ],
}
