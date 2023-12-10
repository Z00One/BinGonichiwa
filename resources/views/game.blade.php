<x-game-layout>
    <div class="leading-10 p-5 text-center text-xl mt-3 sm:mt-10 font-medium text-myFontColor">
        @php
            $boardSize = config('broadcasting.game.boardSize', 5);
        @endphp
        <div class="mb-3">
            <div class="flex justify-center" id="timer">
                <p class="animate-spin">
                    ⏳
                </p>
                <p class="ml-2">
                    {{ __('messages.game.timeLeft') }} :
                </p>
                <p id="countdown" class="ml-1">
                </p>
                <p class="ml-2">
                    {{ __('messages.game.seconds') }}
                </p>
            </div>
            <div id="turnInfo" class="text-myGreen">
                {{ $turn ? __('messages.game.usersTurn') : __('messages.game.opponentsTurn') }}
            </div>
        </div>
        <div class="grid gap-y-5 gap-x-1 grid-cols-1 md:grid-cols-3" id="bingoId" x-data="{{ $bingoId }}">
            <div class="relative">
                <p>{{ __('messages.game.users') }}</p>
                <div class="inline-block border-[1.3px] border-myFontColor rounded-md overflow-hidden shadow-sm mt-5">
                    @foreach ($bingos[$bingoId] as $rowIndex => $row)
                        <div class="flex w-full">
                            @foreach ($row as $colIndex => $col)
                                <div class="block{{ $col }} flex relative border border-myFontColor text-base justify-center items-center hover:bg-myGreen transition ease-in-out duration-150 w-12 h-12 lg:w-14 lg:h-14 lg:text-xl focus:bg-green-600
                                  @if ($rowIndex === 0 && $colIndex === 0) rounded-ss
                                  @elseif ($rowIndex === 0 && $colIndex === $boardSize) rounded-se
                                  @elseif ($rowIndex === $boardSize && $colIndex === 0) rounded-es
                                  @elseif ($rowIndex === $boardSize && $colIndex === $boardSize) rounded-ee @endif"
                                    onclick="this.focus(); window.Game.setValue('{{ $col }}')" tabindex="0">
                                    {{ $col }}
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="w-[170px] mx-auto">

                <div class="w-full md:mt-28">
                    <x-input class="w-full text-center" type="text" id="inputValue" name="value"
                        placeholder="{{ __('messages.game.value') }}" onchange="window.Game.setValue(this.value)" />
                    <x-button class="mx-5" id="bingoInput"
                        onclick="window.Game.submit()">{{ __('messages.game.submit') }}</x-button>
                    <x-danger-button class="hidden mt-10 animate-bounce" disabled="true" id="bingoSubmitButton"
                        onclick="window.Game.bingoSubmit()">
                        {{ __('messages.game.bingo') }}
                    </x-danger-button>
                </div>

                <div class="hidden" id="turn" x-data="{{ $turn }}"></div>

            </div>
            <div>
                <p>
                    {{ $opponent }}{{ __('messages.game.opponents') }}
                </p>
                <div class="inline-block border-[1.3px] border-myFontColor rounded-md overflow-hidden shadow-sm mt-5">
                    @foreach ($bingos[$opponentBingoId] as $rowIndex => $row)
                        <div class="flex">
                            @foreach ($row as $colIndex => $col)
                                <div
                                    class="{{ 'block' . $col }} border border-myFontColor w-12 h-12 transition ease-in-out duration-150 lg:w-14 lg:h-14 lg:text-xl
                                      @if ($rowIndex === 0 && $colIndex === 0) rounded-ss 
                                      @elseif ($rowIndex === 0 && $colIndex === $boardSize) rounded-se 
                                      @elseif ($rowIndex === $boardSize && $colIndex === 0) rounded-es 
                                      @elseif ($rowIndex === $boardSize && $colIndex === $boardSize) rounded-ee @endif">
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="hidden" id="channel" x-data="{{ $gameChannel }}"></div>
    </div>
    <script>
        const usersTurnText = '{{ __('messages.game.usersTurn') }}';
        const opponentsTurnText = '{{ __('messages.game.opponentsTurn') }}';
        const notAvailableValuesMessage = '{{ __('messages.game.notAvailableValuesMessage') }}';
        const notUsersTurnMessage = '{{ __('messages.game.notUsersTurnMessage') }}';
        const errorMessage = '{{ __('messages.game.errorMessage') }}';
        const opponentHasLeftMessage = '{{ __('messages.game.opponentHasLeftMessage') }}';
        const opponentNotParticipatedMessage = '{{ __('messages.game.opponentNotParticipatedMessage') }}';
        const bingoChannel = '{{ $bingoChannel }}';
        const winMessage = '{{ __('messages.game.winMessage') }}';
        const loseMessage = '{{ __('messages.game.loseMessage') }}';
        const userId = {{ $userId }};
        const submitedValues = [];

        const boardSize = {{ $boardSize }};
        const usersBoard = @json($bingos[$bingoId]);

        document.addEventListener('DOMContentLoaded', () => {

            const inputValue = document.querySelector("#inputValue");
            const button = document.querySelector('#bingoInput');
            const channel = document.querySelector('#channel').getAttribute('x-data');
            const turn = document.querySelector('#turn').getAttribute('x-data') ? true : false;
            const turnInfo = document.querySelector('#turnInfo');
            const bingoSubmitButton = document.querySelector('#bingoSubmitButton');

            const state = {
                inputValue,
                button,
                channel,
                turn,
                turnInfo,
                usersTurnText,
                opponentsTurnText,
                notAvailableValuesMessage,
                notUsersTurnMessage,
                errorMessage,
                opponentHasLeftMessage,
                opponentNotParticipatedMessage,
                bingoSubmitButton,
                userId,
                bingoChannel,
                winMessage,
                loseMessage,
                userId,
                submitedValues,
            }

            const bingoId = document.querySelector('#bingoId').getAttribute('x-data');

            const bingoState = {
                boardSize,
                usersBoard,
                bingoId,
            }

            const countdownElement = document.querySelector('#countdown');
            const timerElement = document.querySelector('#timer');

            const timerState = {
                countdownElement,
                timerElement,
            }

            window.Game.init({
                state,
                bingoState,
                timerState
            });

            window.alert('{{ __('messages.game.guide') }}' + `: ${window.Game.bingoInstance.standardOfBingo}`);
        });
    </script>
</x-game-layout>
