<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('components.head')

<body>
    @include('components.header')

    <div class="max-w-screen-lg mx-auto flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-24 sm:mt-0"
        style="min-height: 90vh">
        <div class="w-full sm:w-screen-lg py-2 overflow-hidden text-center text-myRed">
            <p class="text-7xl sm:text-9xl">404</p>
            <p class="text-sm sm:text-xl">{{ __('messages.errors.404') }}</p>
        </div>
        <a href="javascript:history.back()" class="mt-10 sm:mt-15">
            <x-danger-button>
                {{ __('messages.back') }}
            </x-danger-button>
        </a>
    </div>
</body>

</html>
