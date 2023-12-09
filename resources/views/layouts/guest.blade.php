<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('components.head')

<body>
    @include('components.header')

    <div class="max-w-screen-lg mx-auto flex flex-col sm:justify-center items-center pt-6 sm:pt-0"
        style="min-height: 90vh">
        <div class="w-full sm:w-screen-lg py-2 overflow-hidden">
            {{ $slot }}
        </div>
    </div>

</body>
@livewireScripts

</html>
