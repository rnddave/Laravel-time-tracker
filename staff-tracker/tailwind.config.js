module.exports = {
    darkMode: 'class', // Enable dark mode
    content: [
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
    ],
    theme: {
      extend: {
        fontFamily: {
          sans: ['Inter', 'sans-serif'],
        },
        colors: {
          primary: {
            light: '#3b82f6', // Blue-500
            DEFAULT: '#1d4ed8', // Blue-700
            dark: '#1e40af', // Blue-800
          },
          secondary: {
            light: '#6b7280', // Gray-500
            DEFAULT: '#4b5563', // Gray-600
            dark: '#374151', // Gray-700
          },
        },
        spacing: {
          '128': '32rem',
          '144': '36rem',
        },
      },
    },
    plugins: [],
  }
  