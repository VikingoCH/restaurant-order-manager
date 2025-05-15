<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use  WithPagination;

    public $dateRange = '--';
    public $monthYear = '';
    public $showing = '';

    public function mount()
    {
        $this->showing = __('labels.all');
    }

    public function headers(): array
    {
        return [
            ['key' => 'is_open', 'label' => '', 'class' => 'w-1'],
            ['key' => 'number', 'label' => __('labels.order_number')],
            ['key' => 'table', 'label' => __('labels.table'), 'class' => 'w-3'],
            ['key' => 'total', 'label' => __('labels.amount_order'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'w-48'],
            ['key' => 'total_order', 'label' => __('labels.total_paid'), 'format' => ['currency', '2.\'', 'CHF ']],
            ['key' => 'created_at', 'label' => __('labels.open_at'), 'format' => ['date', 'Y/m/d (H:i)']],
            ['key' => 'updated_at', 'label' => __('labels.closed_at'), 'format' => ['date', 'Y/m/d (H:i)']],
        ];
    }

    public function dateRanges(): array
    {
        return [
            ['id' => '--', 'name' => __('labels.all')],
            ['id' => 'today', 'name' => __('labels.date_today')],
            ['id' => 'yesterday', 'name' => __('labels.date_yesterday')],
            ['id' => 'this_week', 'name' => __('labels.date_this_week')],
            ['id' => 'last_week', 'name' => __('labels.date_last_week')],
            ['id' => 'this_month', 'name' => __('labels.date_this_month')],
            ['id' => 'last_month', 'name' => __('labels.date_last_month')],
        ];
    }

    // Date picker plugin settings
    public function datePlugin()
    {
        if (session()->has('locale'))
        {
            $locale = session('locale');
        }
        else
        {
            $locale = app()->getLocale();
        }

        return [
            'locale' => $locale,
            'plugins' => [
                [
                    'monthSelectPlugin' => [
                        'dateFormat' => 'm.Y',
                        'altFormat' => 'F Y',
                    ],
                ],
            ],
        ];
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'dateRange')
        {
            $this->monthYear = '';
            $this->showing = $this->dateRanges()[array_search($this->dateRange, array_column($this->dateRanges(), 'id'))]['name'];
        }
        elseif ($propertyName === 'monthYear')
        {
            if ($this->monthYear)
            {
                $this->dateRange = '';
                $this->showing = __('labels.date_by_month') . ' ' . $this->monthYear;
            }
            else
            {
                $this->dateRange = '--';
            }
        }
    }

    public function closeOrders()
    {
        return Order::query()
            ->when($this->dateRange || $this->monthYear, function ($query)
            {
                if ($this->dateRange === 'today')
                {
                    $query->whereDate('updated_at', today());
                }
                elseif ($this->dateRange === 'yesterday')
                {
                    $query->whereDate('updated_at', now()->subDay());
                }
                elseif ($this->dateRange === 'this_week')
                {
                    $query->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()]);
                }
                elseif ($this->dateRange === 'last_week')
                {
                    $query->whereBetween('updated_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                }
                elseif ($this->dateRange === 'this_month')
                {
                    $query->whereMonth('updated_at', now()->month);
                }
                elseif ($this->dateRange === 'last_month')
                {
                    $query->whereMonth('updated_at', now()->subMonth()->month);
                }
                elseif ($this->monthYear)
                {
                    $year = substr($this->monthYear, strrpos($this->monthYear, '.') + 1);
                    $month = substr($this->monthYear, 0, 2);
                    $query->whereMonth('updated_at', $month)->whereYear('updated_at', $year);
                }
            })
            ->where('is_open', false)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
    }

    public function totals()
    {
        return Transaction::query()
            ->selectRaw('order_id as id, SUM(total) as total_sum')
            ->groupBy('order_id')
            ->get();
    }

    public function render()
    {
        return view('livewire.orders.index', [
            // 'closeOrders' => Order::where('is_open', false)->orderBy('updated_at', 'desc')->paginate(20),
            'closeOrders' => $this->closeOrders(),
            'openOrders' => Order::where('is_open', true)->orderBy('updated_at', 'desc')->take(10)->get(),
            'totals' => $this->totals(),
            // 'closedOrders' => Order::with('place')->where('is_open', false)->orderBy('created_at', 'desc')->paginate(10),
            'headers' => $this->headers(),
            'dateRanges' => $this->dateRanges(),
            'datePlugin' => $this->datePlugin(),
        ]);
    }
}
