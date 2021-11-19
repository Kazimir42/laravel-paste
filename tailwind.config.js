const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        textColor: theme => ({
            ...theme('colors'),
            'primary': '#d97705'
        }),
        borderColor: theme => ({
            ...theme('colors'),
            'primary': '#d97705',
            'base' : '#2b2b2b',
            'second': '#252525',
            'quote': '#434447'
        }),
        backgroundColor: {
            'primary': '#d97705',
            'base' : '#2b2b2b',
            'second': '#252525',
            'quote': '#434447'
        },
        extend: {
            screens: {
                light: { raw: "(prefers-color-scheme: light)" },
                dark: { raw: "(prefers-color-scheme: dark)" }
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        }
    },
    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        function({ addBase, config }) {
            addBase({
                body: {
                    color: config("theme.colors.black"),
                    backgroundColor: config("theme.colors.white")
                },
                "@screen dark": {
                    body: {
                        color: config("theme.colors.white"),
                        backgroundColor: config("theme.colors.black")
                    }
                }
            });
        }
    ]
};
