<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">

        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <style>[x-cloak] { display: none !important; }</style>
        @filamentStyles
        @vite('resources/css/app.css')
        @livewireStyles
        @livewireScripts
        @stack('scripts')
    </head>

    <body class="antialiased flex h-full flex-col">
        {{ $slot }}
        @filamentScripts
        @vite('resources/js/app.js')
        @livewire('notifications')
    </body>
</html>
