<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('messages.profile.update_password.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('messages.profile.update_password.description') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('messages.profile.update_password.current_password') }}" />
            <x-input id="current_password" type="password" class="mt-1 block w-full" wire:model="state.current_password"
                autocomplete="current-password" />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('messages.profile.update_password.new_password') }}" />
            <x-input id="password" type="password" class="mt-1 block w-full" wire:model="state.password"
                autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation"
                value="{{ __('messages.profile.update_password.confirm_password') }}" />
            <x-input id="password_confirmation" type="password" class="mt-1 block w-full"
                wire:model="state.password_confirmation" autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('messages.profile.saved') }}
        </x-action-message>

        <x-button>
            {{ __('messages.profile.save') }}
        </x-button>
    </x-slot>
</x-form-section>
