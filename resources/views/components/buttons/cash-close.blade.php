<x-button {{ $attributes }} {{ $attributes->merge(['class' => 'btn-primary']) }} icon="gmdi.monetization.on.o"
    label="{{ __('Cash Closing') }}" link="{{ route('reports.cash-close') }}" responsive spinner />
