<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <title>{{ config('app.name', 'laravel') }}</title>
        <link href="https://fonts.bunny.net" rel="preconnect">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-white antialiased">
        <div class="relative grid h-dvh items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="hidden h-full w-full bg-neutral-600 p-10 text-white lg:flex lg:flex-col">
                <x-app-logo>
                    {{ config('app.name', 'Laravel') }}

                </x-app-logo>

                <div class="p-4 text-6xl font-bold xl:ml-60">Welcome</div>
                <div class="xl:ml-110 p-4 text-5xl font-bold text-yellow-200">Bem-vindo</div>
                <div class="p-4 text-7xl font-bold text-red-400 xl:ml-20">Benvenuto</div>
                <div class="xl:ml-85 p-4 text-6xl font-bold text-cyan-300">Bienvenido</div>
                <div class="xl:ml-35 p-4 text-7xl font-bold text-green-300">Willkommen</div>
            </div>
            <div class="flex h-full w-full flex-col justify-center bg-white lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[500px]">
                    <div class="lg:hidden">
                        <x-app-logo class="flex-col items-center" />
                    </div>

                    {{ $slot }}
                </div>
                <div class="mt-10 flex justify-end space-x-4">
                    <x-menus.lang-menu />
                </div>
            </div>
        </div>
    </body>

</html>
