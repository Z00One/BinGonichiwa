<x-app-layout>
    <div class="text-center leading-10 p-5 text-lg sm:text-2xl mt-20 sm:mt-0 font-medium text-myFontColor">
        @auth
            @php
                $user = Auth::user();
                $winCount = $user->wins()->count();
                $loseCount = $user->loses()->count();
                $winningRate = $winCount + $loseCount ? ($winCount / ($winCount + $loseCount)) * 100 . '%' : 'N/A';
            @endphp
            <p class="mt-7">
                {{ __('messages.home.winning_rate', ['name' => $user->name]) }}
            </p>
            <p class="mt-5">
                {{ $winningRate }}
            </p>
            <div class="mt-10">
                <a href="{{ url('waiting') }}">
                    <x-button>
                        {{ __('messages.home.match') }}
                    </x-button>
                </a>
            </div>
        @else
            <div>
                <p>
                    {{ __('messages.home.first') }}
                </p>
                <p class="mt-7">
                    {{ __('messages.home.second') }}
                </p>
                <p class="mt-7">
                    {{ __('messages.home.third') }} 😊
                </p>
            </div>
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
