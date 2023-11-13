<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('components.head')

<body>
    @include('components.header')

    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>

</body>
@livewireScripts

</html>
