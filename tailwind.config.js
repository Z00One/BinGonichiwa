import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                myFontColor: "#232323",
                myGreen: "#61A948",
                myRed: "#DF5A5A",
            },
            fontFamily: {
                sans: ["Orbitron", "Roboto", "Noto Sans KR", "sans-serif"],
            },
        },
    },

    plugins: [forms, typography],
};
