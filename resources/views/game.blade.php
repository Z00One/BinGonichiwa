<x-game-layout>
    <div class="leading-10 p-5 text-center text-xl mt-3 sm:mt-10 font-medium text-myFontColor">
        @php
            $bingos = json_decode($bingos, true);
        @endphp
        <div class="mb-3">
            <div class="flex justify-center">
                <div class="animate-bounce">
                    ⏳ Time Left:
                </div>
                <div id="countdown">
                </div>
                <div>
                    {{ __('messages.game.seconds') }}
                </div>
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
                                <div class="block{{ $col }} flex relative border border-myFontColor text-base justify-center items-center hover:bg-myGreen transition ease-in-out duration-150 w-12 h-12 lg:w-14 lg:h-14 lg:text-xl active:bg-green-600
                                  @if ($rowIndex === 0 && $colIndex === 0) rounded-ss
                                  @elseif ($rowIndex === 0 && $colIndex === 4) rounded-se
                                  @elseif ($rowIndex === 4 && $colIndex === 0) rounded-es
                                  @elseif ($rowIndex === 4 && $colIndex === 4) rounded-ee @endif"
                                    onclick="window.Game.setValue('{{ $col }}')">
                                    {{ $col }}
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="w-[180px] mx-auto">

                <div class="w-full md:mt-28">
                    <x-input class="w-full text-center" type="text" id="inputValue" name="value"
                        onchange="window.Game.setValue(this.value)" />
                    <x-button class="mt-5" id="bingoInput"
                        onclick="window.Game.submit()">{{ __('messages.game.submit') }}</x-button>
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
                                      @elseif ($rowIndex === 0 && $colIndex === 4) rounded-se 
                                      @elseif ($rowIndex === 4 && $colIndex === 0) rounded-es 
                                      @elseif ($rowIndex === 4 && $colIndex === 4) rounded-ee @endif">
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="hidden" id="channel" x-data="{{ $channel }}"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const usersBoard = @json($bingos[$bingoId]);
            const channel = document.querySelector('#channel').getAttribute('x-data');
            const bingoId = document.querySelector('#bingoId').getAttribute('x-data');
            const turn = document.querySelector('#turn').getAttribute('x-data') ? true : false;
            const button = document.querySelector('#bingoInput');
            const turnInfo = document.querySelector('#turnInfo');
            const usersTurnText = '{{ __('messages.game.usersTurn') }}';
            const opponentsTurnText = '{{ __('messages.game.opponentsTurn') }}';
            const boardSize = {{ config('broadcasting.game.boardSize') }};
            const notAvailableValuesMessage = '{{ __('messages.game.notAvailableValuesMessage') }}';
            const notUsersTurnMessage = '{{ __('messages.game.notUsersTurnMessage') }}';
            const errorMessage = '{{ __('messages.game.errorMessage') }}';
            const opponentHasLeftMessage = '{{ __('messages.game.opponentHasLeftMessage') }}';
            const opponentNotParticipatedMessage = '{{ __('messages.game.opponentNotParticipatedMessage') }}';
            const countdownElement = document.querySelector('#countdown');

            console.log(countdownElement);

            window.Game.init({
                channel,
                usersBoard,
                bingoId,
                turn,
                button,
                turnInfo,
                usersTurnText,
                opponentsTurnText,
                boardSize,
                notAvailableValuesMessage,
                notUsersTurnMessage,
                errorMessage,
                opponentHasLeftMessage,
                opponentNotParticipatedMessage,
                countdownElement,
            });

            button.disabled = !turn;

        });
    </script>
</x-game-layout>
