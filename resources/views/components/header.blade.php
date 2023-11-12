<style>
    body {
        margin: 0;
    }

    div {
        font-family: 'Orbitron', 'Roboto', 'Noto Sans KR', sans-serif;
        color: #232323;
    }

    .my-container {
        margin: 10px;
        display: flex;
        align-items: center;
        flex-shrink: 0;
    }

    .favicon img {
        margin: 0 10px 0 5px;
    }

    .favicon h3 {
        font-weight: 600;
    }

    a {
        text-decoration: none;
        font-weight: 500;
        color: rgb(156 163 175);
        transition: .3s;
    }

    a:hover {
        color: inherit;
    }
</style>

<div class="fixed w-full">
    <div class="flex justify-between">
        {{-- 헤더 --}}
        <div>
            <a href="{{ url('/') }}">
                <div class="favicon my-container">
                    <img src="{{ asset('assets/favicon.svg') }}" alt="favicon">
                    <h3>{{ config('app.name', 'BinGonichiwa') }}</h3>
                </div>
            </a>
        </div>
        <div class="my-container">
            {{ $slot }}
        </div>
    </div>
    <hr />
</div>
