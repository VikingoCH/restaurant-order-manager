<x-layouts.pdf>
    <div class="card">
        <table>
            <tr>
                <td>
                    <h3>{{ $date }}</h3>
                </td>
                <td class="right">
                    <h3> {{ __('labels.total') }}: {{ number_format($total[0]->total_sum, 2) }}</h3>
                </td>
            </tr>
        </table>
    </div>
    @foreach ($transactions as $transaction)
        <div class="card">
            <table>
                <tr>
                    <td>
                        <h3>{{ __('labels.order_number') }}: {{ $transaction->number }}</h3>
                    </td>
                    <td class="right">
                        <h3>{{ __('labels.total') }}: {{ $transaction->total }}</h3>
                    </td>
                </tr>
            </table>

            <table class="table-bordered">
                @foreach ($transaction->transactionItems as $item)
                    <tr class="font-small">
                        <td>{{ $item->item }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                @endforeach
            </table>
            <table class="mt-1">
                <tr class="font-small">
                    <th class="left">{{ __('labels.sub_total') }}</th>
                    <th class="left">{{ __('labels.discount') }}</th>
                    <th class="left">{{ __('labels.tax') }}</th>
                    <th class="left">{{ __('labels.tip') }}</th>
                    {{-- <th class="left">{{ __('labels.total') }}</th> --}}
                </tr>
                <tr class="font-bold">
                    <td class="left">{{ number_format($subtotal[$transaction->id], 2) }}</td>
                    <td class="left">{{ $transaction->discount }}</td>
                    <td class="left">{{ $transaction->tax }}</td>
                    <td class="left">{{ $transaction->tip }}</td>
                    {{-- <td class="left">{{ $transaction->total }}</td> --}}
                </tr>
            </table>
        </div>
    @endforeach
</x-layouts.pdf>
