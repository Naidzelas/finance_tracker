/** @type {import('tailwindcss').Config} */
import PrimeUI from 'tailwindcss-primeui';
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [PrimeUI],
};
