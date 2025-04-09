import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import commonjs from "vite-plugin-commonjs";

export default defineConfig({
    plugins: [
        commonjs(),
        laravel({
            input: ["resources/sass/app.scss", "resources/js/app.js", "resources/js/employerDashboard.js", "resources/js/payroll.js"],
            refresh: true,
        }),
    ],
});
