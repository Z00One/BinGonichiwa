<div class="absolute top-0 left-0 w-full">
    <div class="flex justify-between max-w-screen-lg mx-auto">
        <div class="p-2 flex items-center">
            <a href="{{ url('/') }}">
                <div class="flex items-center">
                    <img src="{{ asset('assets/favicon.svg') }}" class="h-8" alt="favicon">
                    <h3 class="ml-2 font-bold">{{ config('app.name', 'BinGonichiwa') }}</h3>
                </div>
            </a>
        </div>
        <div class="flex items-center">
            @auth
                <div class="relative w-full" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                    <div @click="open = ! open">
                        <button type="button"
                            class="inline-flex items-center px-3 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-myFontColor focus:outline-none transition ease-in-out duration-150">
                            <span class="text-xl font-medium" :class="{ 'hidden': open }">☰</span>
                            <span class="text-xl font-light" :class="{ 'hidden': !open }">x</span>
                        </button>
                    </div>

                    <div x-show="open" @click="open = false">
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white text-center"
                            style="position: absolute; left: -98px; top: 3px; min-width: 100px;">

                            <a class="block w-full py-1 text-xs leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                href="http://127.0.0.1:8000/user/profile">{{ __('messages.header.profile') }}</a>
                                
                            <div class="border-t border-gray-200"></div>
                                
                            <a class="block w-full px-1 py-1 text-xs leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            href="{{ url('/records/' . auth()->user()->name) }}">{{ __('messages.header.record') }}</a>
                            
                            <div class="border-t border-gray-200"></div>
                            
                            @if(url()->current() == url('/') || url()->current() == url('/dashboard'))
                                <a class="block w-full px-1 py-1 text-xs leading-5 text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out"
                                href="{{ (session()->get('locale') === 'en') ? url('/set-language/ja') : url('/set-language/en') }}">
                                {{{ __('messages.header.language') }}}
                            </a>
                            
                            <div class="border-t border-gray-200"></div>
                            @endif
                            
                            <form method="POST" action="http://127.0.0.1:8000/logout" id="logout-form">
                                @csrf
                                <a class="block w-full px-1 py-1 text-xs leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                href="#" @click.prevent="$root.submit();"
                                onclick="logout(window.logoutMessage)">{{ __('messages.header.logout') }}</a>
                            </form>

                        </div>
                    </div>
                </div>
            @else
            @if(url()->current() == url('/') || url()->current() == url('/dashboard'))
                    <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out"
                        href="{{ (session()->get('locale') === 'en') ? url('/set-language/ja') : url('/set-language/en') }}">
                        {{ __('messages.header.language') }}
                    </a>
                @endif
            @endauth
        </div>
    </div>
    <hr />
</div>

<script>
    window.logoutMessage = @json(__('messages.auth.logout'));

    const logout = (msg) => {
        const confirmed = window.confirm(msg);

        if (confirmed) {
            document.querySelector('#logout-form').submit();
        }
    }
</script>
