<x-layouts.pdf>
    <div class="card">
        <table>
            <tr>
                <td>
                    <h2>{{ $date }}</h2>
                </td>
                <td class="right">
                    <h2> {{ 'Total ' . $total[0]->total_sum }}</h2>
                </td>
            </tr>
    </div>
    @foreach ($transactions as $transaction)
        <div class="card">
            {{-- <p> --}}
            <h3>{{ __('labels.order_number') }}: {{ $transaction->number }}</h3>
            {{-- <span>{{ __('labels.total') }}: {{ $transaction->total }}</span> --}}
            {{-- </p> --}}

            <table style="margin-top: 1rem; border-top: 1px dashed #aaa; border-bottom: 1px dashed #aaa;">
                @foreach ($transaction->transactionItems as $item)
                    <tr class="font-small">
                        <td>{{ $item->item }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                @endforeach
            </table>
            <table style="margin-top: 1rem;">
                <tr class="font-small">
                    <th class="left">{{ __('labels.sub_total') }}</th>
                    <th class="left">{{ __('labels.discount') }}</th>
                    <th class="left">{{ __('labels.tax') }}</th>
                    <th class="left">{{ __('labels.tip') }}</th>
                    <th class="left">{{ __('labels.total') }}</th>
                </tr>
                <tr style="font-weight: bold;">
                    <td class="left">{{ number_format($subtotal[$transaction->id], 2) }}</td>
                    <td class="left">{{ $transaction->discount }}</td>
                    <td class="left">{{ $transaction->tax }}</td>
                    <td class="left">{{ $transaction->tip }}</td>
                    <td class="left">{{ $transaction->total }}</td>
                </tr>
            </table>
        </div>
    @endforeach
</x-layouts.pdf>
