const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {

                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                fjalla: ['Fjalla One', 'sans-serif']

            },

            colors: {
                "pale-yellow": "#9bc7c7",
                "medium-yellow": "#87a8a8",
                "dark-yellow": "#709999",
                "dark-red": "#3e6b6b",
                "dark-blue": "#015369",
                "pale-blue": "#028bb0"
            },

            dropShadow: {
                boite: "0px 17px 9px rgba(0, 0, 0, 0.35)",
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
