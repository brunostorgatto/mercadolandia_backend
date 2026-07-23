<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Mercadolandia') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="/favicon.ico">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-full bg-slate-900 text-slate-100 overflow-x-hidden selection:bg-emerald-500 selection:text-white">
        <!-- Ambient Background Lights & Gradients -->
        <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 -right-20 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:24px_24px] opacity-40"></div>
        </div>

        <div class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8 relative z-10">
            <div class="w-full max-w-md space-y-6">
                <!-- Header / Logo -->
                <div class="flex flex-col items-center justify-center text-center">
                    <a href="/" class="group transition duration-300 transform hover:scale-105">
                        <x-application-logo />
                    </a>
                </div>

                <!-- Main Card Container -->
                <div class="w-full bg-white/95 backdrop-blur-xl text-slate-800 p-8 rounded-3xl shadow-2xl shadow-emerald-950/40 border border-white/20 transition-all duration-300">
                    {{ $slot }}
                </div>

                <!-- Footer note -->
                <div class="text-center text-xs text-slate-400">
                    &copy; {{ date('Y') }} Mercadolandia. Todos os direitos reservados.
                </div>
            </div>
        </div>
    </body>
</html>

