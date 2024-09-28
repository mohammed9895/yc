const colors = require('tailwindcss/colors')

module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/livewire/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './resources/vendor/**/*.blade.php',
        './resources/views/vendor/zeus/**/*.blad`e.php',
        './vendor/lara-zeus/core/resources/views/**/*.blade.php',
        './vendor/lara-zeus/bolt/resources/views/themes/**/*.blade.php',
        './vendor/lara-zeus/bolt/resources/views/filament/**/*.blade.php',
        './vendor/kenepa/translation-manager/resources/views/*.blade.php',
    ],
    theme: {
        container: {
            padding: '1rem',
        },
        extend: {
            colors: {
                danger: colors.rose,
                primary: colors.purple,
                success: colors.green,
                warning: colors.yellow,
                manjam_primary: '#684e9a',
                primary_purple: '#6512D9'
            },
            animation: {
                marquee: 'marquee 25s linear infinite',
            },
            keyframes: {
                marquee: {
                    '0%': {transform: 'translateY(0%)'},
                    '100%': {transform: 'translateY(-50%)'},
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
