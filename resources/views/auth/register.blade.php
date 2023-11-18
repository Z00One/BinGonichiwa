<x-guest-layout>
    <x-authentication-card>
        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('messages.auth.name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="ID" />
                <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')"
                    required autocomplete="email" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('messages.auth.password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('messages.auth.confirm_password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-200 hover:text-myGreen rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('messages.auth.already_registered') }}
                </a>

                <x-button class="ms-4">
                    {{ __('messages.auth.register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
