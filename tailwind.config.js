/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./views/**/*.php"],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: "#ec4899",
          50: "#fdf2f8",
          100: "#fce7f3",
          200: "#fbcfe8",
          300: "#f9a8d4",
          400: "#f472b6",
          500: "#ec4899", // warna utama
          600: "#db2777",
          700: "#be185d",
          800: "#9d174d",
          900: "#831843",
        },
      },
      fontFamily: {
        poppins: ["Poppins"],
      },
    },
  },
  plugins: [],
};
