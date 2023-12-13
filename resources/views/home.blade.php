<x-app-layout>
    <div class="text-center leading-10 p-5 text-lg sm:text-2xl mt-20 sm:mt-0 font-medium text-myFontColor">
        @auth
            @php
                $user = Auth::user();
                $winCount = $user->wins()->count();
                $loseCount = $user->loses()->count();
                $winningRate = $winCount + $loseCount ? number_format(($winCount / ($winCount + $loseCount)) * 100, 2) . '%' : 'N/A';
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

<footer class="text-center py-4 bg-myFontColor text-white text-xs fixed bottom-0 w-full">
    <p>© 2023 by Juwon Kang. All rights reserved.</p>
    <p class="mt-3">
        <a href="https://github.com/Z00one" target="_blank" class="text-myGreen hover:text-green-500">Github</a>
    </p>
</footer>
