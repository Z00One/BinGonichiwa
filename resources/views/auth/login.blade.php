<x-guest-layout>
    <x-authentication-card>
        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <x-label for="email" value="ID" />
                <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('id')" required
                    autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('messages.auth.password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-end mt-2">
                <a href="{{ route('register') }}"
                    class="text-gray-200 hover:text-myGreen transition ease-in-out duration-150">
                    {{ __('messages.auth.register') }}</a>
                <x-button class="ms-4">
                    {{ __('messages.auth.login') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
