<div class="mt-4 flex flex-col gap-6">
    <div class="text-center">
        {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="!dark:text-green-400 text-center font-medium !text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3">
        <x-button class="btn-accent w-full" label="{{ __('Resend verification email') }}" wire:click="sendVerification" />

        <x-button class="btn-ghost text-warning text-sm" label="{{ __('Log out') }}" wire:click="logout" />
    </div>
</div>
