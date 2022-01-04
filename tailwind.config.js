const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                black: {
                    500: '#090909',
                    450: '#101010',
                    400: '#121212',
                    300: '#212121',
                    200: '#535353',
                    100: '#b3b3b3'
                },
            },
            width: theme => ({
                "106": "26rem",
                "114": "28rem",
                "122": "30rem",
            }),
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
