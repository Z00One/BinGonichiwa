<style>
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

    .BinGonichiwa {
        text-decoration: none;
        font-weight: 500;
        color: #232323;
        transition: .3s;
    }
</style>

<div class="w-full mb-5">
    <div class="flex justify-between">
        <div>
            <a href="{{ url('/') }}" class="{{ config('app.name', 'BinGonichiwa') }}">
                <div class="favicon my-container">
                    <img src="{{ asset('assets/favicon.svg') }}" alt="favicon">
                    <h3>{{ config('app.name', 'BinGonichiwa') }}</h3>
                </div>
            </a>
        </div>
        <div class="my-container">
            <div>
                @auth
                    <div class="relative w-full" x-data="{ open: false }" @click.away="open = false"
                        @close.stop="open = false">
                        <div @click="open = ! open">
                            <button type="button"
                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <span class="text-2xl" :class="{ 'hidden': open }">+</span>
                                <span class="text-xl" :class="{ 'hidden': !open }">x</span>
                            </button>
                        </div>

                        <div x-show="open" @click="open = false">
                            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white"
                                style="position: absolute; left: -90px; top:0">

                                <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                    href="http://127.0.0.1:8000/user/profile">Profile</a>

                                <div class="border-t border-gray-200"></div>

                                <form method="POST" action="http://127.0.0.1:8000/logout" id="logout-form">
                                    @csrf
                                    <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        href="#" @click.prevent="$root.submit();" onclick="logout()">LogOut</a>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    @if (request()->path() === 'login')
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900">Register</a>
                    @elseif (request()->path() === 'register')
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">LogIn</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">LogIn</a>
                        <a href="{{ route('register') }}" class="ml-4 text-gray-600 hover:text-gray-900">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    <hr />
</div>

<script>
    const logout = () => {
        const confirmed = window.confirm("로그아웃 하시겠습니까?");

        if (confirmed) {
            document.querySelector('#logout-form').submit();
        }
    }
</script>
