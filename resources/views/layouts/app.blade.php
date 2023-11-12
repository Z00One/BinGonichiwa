<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&family=Orbitron:wght@400;600&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body>
    <x-header>
        <div class="relative w-full" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
            <div @click="open = ! open">
                <button type="button"
                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <span class="text-2xl" :class="{ 'hidden': open }">+</span>
                    <span class="text-xl" :class="{ 'hidden': !open }">x</span>
                </button>
            </div>

            <div x-show="open" @click="open = false">
                <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white"
                    style="position: absolute; left: -90px; top:0">

                    <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                        href="http://127.0.0.1:8000/user/profile">Profile</a>

                    <div class="border-t border-gray-200"></div>

                    <form method="POST" action="http://127.0.0.1:8000/logout" x-data="">
                        @csrf
                        <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            href="http://127.0.0.1:8000/logout" @click.prevent="$root.submit();">LogOut</a>
                    </form>
                </div>
            </div>
        </div>
    </x-header>
    <main>
        {{ $slot }}
    </main>
</body>
@stack('modals')

@livewireScripts

</html>
