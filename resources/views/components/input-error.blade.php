@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'text-sm text-red-600']) }}>
        @if ($message === 'This password does not match our records.')
            {{ __('messages.auth.wrong') }}
        @else
            {{ $message }}
        @endif
    </p>
@enderror
