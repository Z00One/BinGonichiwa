<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:w-screen-lg py-2 mt-16 overflow-hidden">
            @auth
            @else
                <div class="text-center leading-10 px-5">
                    <p class="text-2xl font-medium text-myFontColor">
                        {{ __('messages.dashboard.first') }}
                    </p>
                    <p class="mt-7 text-2xl font-medium text-myFontColor">
                        {{ __('messages.dashboard.second') }}
                    </p>
                    <p class="mt-7 text-2xl font-medium text-myFontColor">
                        {{ __('messages.dashboard.third') }} 😊
                    </p>
                    <div class="mt-10">
                        <a href="{{ route('login') }}">
                            <x-button class="ms-4">
                                {{ 'LogIn' }}
                            </x-button>
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>
