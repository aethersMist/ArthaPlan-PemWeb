import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                display: ["Poppins", "sans-serif"], // ✅ font custom
            },
            colors: {
                primary: {
                    DEFAULT: "#285539",
                    soft: "#394c3e",
                    dark: "#2f3c33",
                },
                accent: "#88cf0f",
                base: "#f2f2e8",
                light: "#fdfdfd",
                dark: "#181818",

                netral: {
                    DEFAULT: "#6c757d",
                    light: "#9ca3af",
                    dark: "#9ca3af",
                },
                info: "#6366f1",
                danger: {
                    DEFAULT: "#ef4444",
                    dark: "#991b1b",
                },
            },
        },
    },
    plugins: [forms, "flowbite/plugin"],
};
