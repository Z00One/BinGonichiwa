<div>

    @auth
        <div class="relative w-full" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
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

                    <form method="POST" action="http://127.0.0.1:8000/logout" x-data="">
                        @csrf
                        <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            href="http://127.0.0.1:8000/logout" @click.prevent="$root.submit();">LogOut</a>
                    </form>
                </div>
            </div>
        </div>
    @else
        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">LogIn</a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-gray-600 hover:text-gray-900">Register</a>
        @endif
    @endauth
</div>
