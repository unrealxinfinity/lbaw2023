/** @type {import('tailwindcss').Config} */
export default {
  important: true,
  content: [
    "./resources/views/**/*.blade.php",
    "./public/js/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],
  theme: {
    screens: {
      mobile: '450px',
      tablet: '650px',
      desktop: '1024px'
    },
    colors: {
      white: '#ffffff',
      black: '#090909',
      grey: '#5E716A',
      dark: '#222222',
      green: '#008000',
      darkGreen: '#14532D',
      red: '#FF0000',
      darkRed: '#8b0000',
      orange: '#ba610b',
    },
    fontFamily: {
      roboto: ['Roboto', 'sans-serif'],
      minecraft: ['Minecraft', 'sans-serif']
    },
    fontSize: {
      sMobile: '9px',
      sTablet: '11px',
      sDesktop: '12px',
      msMobile: '10px',
      msTablet: '12px',
      msDesktop: '13px',
      mMobile: '11px',
      mTablet: '15px',
      mDesktop: '17px',
      bMobile: '17px',
      bTablet: '20px',
      bDesktop: '23px',
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
        'mine': "url('/resources/img/dark.png')",
        'mine-lime': "url('/resources/img/lime.png')",
        'mine-red': "url('/resources/img/red.png')",
      },
      maxWidth: {
        '1/2': '50%',
        '1/4': '25%',
      },
      minWidth: {
        '1/2': '50%',
        '1/4': '25%',
      },
      minHeight: {
        '128': '16rem',
      },
    }
  },
  plugins: [
    function ({ addVariant }) {
      addVariant('child', '& > *');
    },
  ],
}
