<x-app-layout>
    <style>
        .wave_before {
            content: "";
            width: 200%;
            height: 200%;
            background-color: #ffffff;
            position: absolute;
            top: -100%;
            left: -50%;
            border-radius: 40%;
            animation: anim 12s linear infinite;
        }

        .wave_after {
            content: "";
            width: 204%;
            height: 204%;
            background-color: #ececec70;
            position: absolute;
            top: -100%;
            left: -52%;
            border-radius: 40%;
            animation: anim 12s linear infinite;
            animation-delay: 0.5s;
        }

        @keyframes anim {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div class="overflow-x-auto mx-4 sm:mx-10 mt-16">

        <div class="flex justify-evenly text-xs sm:text-sm">
            <div class="relative min-w-[120px] min-h-[120px] sm:min-w-[180px] sm:min-h-[180px] rounded-full border border-myFontColor overflow-hidden bg-myGreen"
                id="winning_rate" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%)"
                data-winning-rate="{{ $user['winningRate'] }}">
                <div class="wave_before"></div>
                <div class="wave_after"></div>
                <div class="absolute top-0 left-0 w-full h-full flex justify-center items-center text-center sm:text-lg">
                    {{ __('messages.records.winning_rate') }}
                    <br /> {{ $user['winningRate'] == 0 ? 'N/A' : $user['winningRate'] . '%' }}
                </div>
            </div>

            <div class="flex items-center max-w-[400px]">
                <div>
                    <div class="my-1 text-sm sm:text-2xl font-medium text-gray-900">
                        {{ $name }} {{ __('messages.records.name') }}
                    </div>

                    <div class="mt-4 text-gray-600 sm:text-lg">
                        {{ $user['winCount'] + $user['loseCount'] }} {{ __('messages.records.games') }}
                        {{ $user['winCount'] }} {{ __('messages.records.win') }}
                        {{ $user['loseCount'] }} {{ __('messages.records.lose') }}
                    </div>
                </div>
            </div>
        </div>

        @if (count($records) == 0)
            <div class="py-2 border-b border-gray-200　text-center mt-8">
                {{ __('messages.records.no_records') }}
            </div>
        @else
            <div class="rounded-lg border border-gray-200 mt-8 overflow-hidden text-center text-xs sm:text-sm">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="rounded-sm border-gray-200 bg-gray-50 text-gray-500 uppercase">
                            <th class="px-1 py-2 border-b border-gray-200 font-medium" style="width: 30%">
                                {{ __('messages.records.opponent') }}
                            </th>
                            <th class="px-1 py-2 border-b border-gray-200 bg-gray-50 font-medium" style="width: 30%">
                                {{ __('messages.records.result') }}
                            </th>
                            <th class="px-1 py-2 border-b border-gray-200 bg-gray-50 font-medium" style="width: 40%">
                                {{ __('messages.records.time') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $record)
                            <tr class="text-myFontColor hover:text-black">
                                <td class="py-2 whitespace-no-wrap border-b border-gray-200">
                                    @if ($record->opponent == null)
                                        <a>{{ __('messages.records.withdrawal') }}</a>
                                    @else
                                        <a
                                            href="{{ url('/records/' . $record->opponent) }}">{{ $record->opponent }}</a>
                                    @endif
                                </td>
                                <td class="py-2 whitespace-no-wrap border-b border-gray-200">
                                    {{ $record->isWin ? __('messages.records.win') : __('messages.records.lose') }}
                                </td>
                                <td class="py-2 whitespace-no-wrap border-b border-gray-200">
                                    {{ $record->created_at }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="flex justify-center text-center py-2 mt-4 text-gray-400 text-xs sm:text-sm">
            @if ($records->hasPages())
                @if (!$records->onFirstPage())
                    <a class="hover:text-myFontColor focus:outline-none transition ease-in-out duration-150"
                        href="{{ $records->previousPageUrl() }}" rel="prev">
                        {{ __('messages.records.page_prev') }}
                    </a>
                @endif
                @if ($records->hasMorePages())
                    @if (!$records->onFirstPage())
                        <span class="mx-4 text-myFontColor">|</span>
                    @endif
                    <a class="hover:text-myFontColor focus:outline-none transition ease-in-out duration-150"
                        href="{{ $records->nextPageUrl() }}" rel="next">
                        {{ __('messages.records.page_next') }}
                    </a>
                @endif
            @endif
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const updateWinningRate = () => {
                const waveBefore = document.querySelector('.wave_before');
                const waveAfter = document.querySelector('.wave_after');
                const winningRate = document.querySelector('#winning_rate').getAttribute('data-winning-rate');
                const TOP = -103;

                if (waveBefore) {
                    const topValue = TOP - winningRate;
                    waveBefore.style.top = `${topValue}%`;
                }

                if (waveAfter) {
                    const topValue = TOP - winningRate;
                    waveAfter.style.top = `${topValue}%`;
                }
            }

            updateWinningRate();
        });
    </script>
</x-app-layout>
