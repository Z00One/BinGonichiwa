<x-app-layout>
    <div class="text-center leading-10 px-5">
        @auth
            @php
                $user = Auth::user();
                $winCount = $user->wins()->count();
                $loseCount = $user->loses()->count();
                $winningRate = ($winCount / ($winCount + $loseCount)) * 100 . '%';
            @endphp
            <p class="mt-7 text-2xl font-medium text-myFontColor">
                {{ __('messages.dashboard.winning_rate', ['name' => $user->name]) }}
            </p>
            <p class="mt-5 text-2xl font-medium text-myFontColor">
                {{ $winningRate }}
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
</x-app-layout>
