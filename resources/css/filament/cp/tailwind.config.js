import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Cp/**/*.php',
        './resources/views/filament/cp/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './resources/views/**/*.blade.php',
        './resources/views/vendor/**/*.blade.php',
        './resources/view/vendor/zeus/**/*.blade.php',
    ],
}
