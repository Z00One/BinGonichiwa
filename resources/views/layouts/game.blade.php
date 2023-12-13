<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('components.head')

<body>
    <header class="absolute top-0 left-0 w-full">
        <div class="max-w-screen-lg mx-auto p-2">
            <div class="flex items-center">
                <img src="{{ asset('assets/favicon.svg') }}" class="h-8" alt="favicon">
                <h3 class="ml-2 font-bold">{{ config('app.name', 'BinGonichiwa') }}</h3>
            </div>
        </div>
        <hr />
    </header>
    <div class="max-w-screen-lg mx-auto flex flex-col sm:justify-center items-center pt-6 sm:pt-0"
        style="min-height: 90vh">
        <div class="w-full sm:w-screen-lg py-2 overflow-hidden">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
