/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./views/**/*.php"],
  theme: {
    extend: {
      colors: {
        primary: "#059669",
        "primary-50": "#ecfdf5",
        "primary-100": "#d1fae5",
        "primary-500": "#059669",
        "primary-600": "#047857",
        "primary-700": "#065f46",
      },
      fontFamily: {
        sans: ["Inter", "system-ui", "sans-serif"],
      },
    },
  },
  plugins: [],
};
