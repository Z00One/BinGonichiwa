<x-game-layout>
    <div class="text-center leading-10 p-5 text-lg sm:text-2xl mt-10 sm:mt-0 font-medium text-myFontColor">
        <div class="mt-10">

            {{-- Spinner --}}
            <div role="status">
                <svg aria-hidden="true" class="inline w-12 text-gray-100 animate-spin dark:text-gray-300 fill-gray-100"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
            </div>

            {{-- Waiting Message --}}
            <div class="mt-10">
                <p>{{ __('messages.waiting.wait') }}
                <p>
                <div class="mt-5 text-myRed text-xs sm:text-lg">
                    <p>📌 {{ __('messages.waiting.caution_first') }}
                    <p>
                    <p>{{ __('messages.waiting.caution_second') }}
                    <p>
                </div>
            </div>

            {{-- Cancel Button --}}
            <form action="waiting/leave" method="post" id="leave-form">
                @csrf
                @method('patch')
                <input type="hidden" name={{ config('broadcasting.game.channel') }} value="{{ $channel }}">
                <x-danger-button class="mt-10" onclick="window.Waiting.leave()">
                    {{ __('messages.waiting.match_cancel') }}
                </x-danger-button>
            </form>

            <div id="channel" x-data={{ $channel }}>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const channel = document.getElementById('channel').getAttribute('x-data');
            const leaveForm = document.querySelector('#leave-form');
            const leaveConfirmMessage = '{{ __('messages.waiting.cancel_confirm') }}';
            const opponentleaveMessage = '{{ __('messages.waiting.opponent_leave') }}';
            const gameStartMessage = '{{ __('messages.waiting.start') }}';
            const errorMessage = '{{ __('messages.waiting.error') }}';
            const playerCount = {{ config('broadcasting.game.players') }};

            window.Waiting.init({
                channel,
                leaveForm,
                leaveConfirmMessage,
                opponentleaveMessage,
                gameStartMessage,
                errorMessage,
                playerCount,
            })
        });
    </script>
</x-game-layout>
