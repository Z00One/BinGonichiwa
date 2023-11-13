<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('components.head')

<body>
    @include('components.header')

    <main>
        {{ $slot }}
    </main>
</body>

@stack('modals')

@livewireScripts

</html>
