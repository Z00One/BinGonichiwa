<x-app-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="min-height: 90vh">
        <div class="w-full sm:w-screen-lg py-2 mt-16 overflow-hidden">
            <div class="text-center leading-10 px-5">
                @auth
                    @php
                        $currentUser = Auth::user();
                    @endphp
                    <p class="text-2xl font-medium text-myFontColor">
                        {{ $currentUser->name }}{{ __('messages.dashboard.record') }}
                    </p>
                    <p class="mt-7 text-2xl font-medium text-myFontColor">
                        {{ $currentUser->records()->count() }} {{ __('messages.dashboard.games') }}
                        {{ $currentUser->records()->where('is_win', true)->count() }} {{ __('messages.dashboard.wins') }}
                        {{ $currentUser->records()->where('is_win', false)->count() }} {{ __('messages.dashboard.loses') }}
                    </p>
                    <div class="mt-10">
                        <a href="">
                            <x-button>
                                {{ __('messages.dashboard.match') }}
                            </x-button>
                        </a>
                    </div>
                @else
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
                            <x-button>
                                {{ __('messages.auth.login') }}
                            </x-button>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
