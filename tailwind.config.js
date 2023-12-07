/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/views/**/*.blade.php",
    "./public/js/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],
  theme: {
    screens: {
      sm: '480px',
      md: '780px',
      lg: '976px',
      xl: '1440px',
      mobile: '450px',
      tablet: '601px',
      desktop: '1024px'
    },
    colors: {
      white: '#ffffff',
      black: '#000000',
      grey: '#5E716A',
      green: '#008000',
      red: '#FF0000',
    },
    fontFamily: {
      roboto: ['Roboto', 'sans-serif'],
      minecraft: ['Minecraft', 'sans-serif']
    },
    fontSize: {
      sMobile: '9px',
      sTablet: '11px',
      sDesktop: '12px',
      mMobile: '11px',
      mTablet: '15px',
      mDesktop: '17px',
      bMobile: '17px',
      bTablet: '20px',
      bDesktop: '23px',
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
