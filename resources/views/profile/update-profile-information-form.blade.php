<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('messages.profile.update_information.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('messages.profile.update_information.description') }}
    </x-slot>

    <x-slot name="form">
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('messages.profile.update_information.name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required
                autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- ID -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="id" value="{{ __('messages.profile.update_information.id') }}" />
            {{-- 'id' 값을 'email' 필드에 사용하여 사용자 아이디를 입력하도록 설정 --}}
            <x-input id="email" type="text" class="mt-1 block w-full" wire:model="state.email" required
                autocomplete="username" />
            <x-input-error for="email" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('messages.profile.saved') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('messages.profile.save') }}
        </x-button>
    </x-slot>
</x-form-section>
