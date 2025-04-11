{{-- <section class="w-full">
    @include('partials.page-heading') --}}

<x-settings.layout :heading="__('labels.profile')" :subheading="__('Update your name and email address')">
    <x-form wire:submit="updateProfileInformation">
        <x-input autofocus icon="o-user" label="{{ __('labels.name') }}" placeholder="name" required wire:model="name" />

        <div>
            <x-input icon="o-at-symbol" label="{{ __('labels.email') }}" placeholder="email" required type="email"
                wire:model="email" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div>
                    <x-alert class="alert-info alert-soft mt-2"
                        description="{{ __('click on send it link to re-send verificaiton Email') }}"
                        icon="o-exclamation-triangle" title="{{ __('Your email address is unverified.') }}">
                        <x-slot:actions>
                            <x-button class="btn-ghost" label="{{ __('send it!') }}"
                                tooltip-bottom="{{ __('Click here to re-send the verification email.') }}"
                                wire:click.prevent="resendVerificationNotification" />
                        </x-slot:actions>
                    </x-alert>

                    @if (session('status') === 'verification-link-sent')
                        <x-alert class="alert-success alert-soft mt-2 font-bold" icon="o-check-circle"
                            title="{{ __('A new verification link has been sent to your email address.') }}" />
                    @endif
                </div>
            @endif
        </div>
        <x-button class="btn-secondary w-full" type="submit">{{ __('actions.save') }}</x-button>
    </x-form>

</x-settings.layout>
{{-- </section> --}}
