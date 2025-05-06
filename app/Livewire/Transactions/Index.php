<?php

namespace App\Livewire\Transactions;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public array $expanded = [];
    public $dateRange = 'today';
    public $monthYear = '';
    public $showing = '';

    public function mount()
    {
        $this->showing = __('labels.date_today');
    }

    public function headers(): array
    {
        return [
            ['key' => 'number', 'label' => __('labels.order_number'), 'class' => 'w-3'],
            ['key' => 'table', 'label' => __('labels.table'), 'class' => 'w-3'],
            ['key' => 'total', 'label' => __('labels.amount'), 'format' => ['currency', '2.\'', 'CHF ']],
            ['key' => 'created_at', 'label' => __('labels.open_at'), 'format' => ['date', 'Y/m/d (H:i)']],
            ['key' => 'updated_at', 'label' => __('labels.closed_at'), 'format' => ['date', 'Y/m/d (H:i)']],
        ];
    }

    public function dateRanges(): array
    {
        return [
            ['id' => '', 'name' => '--'],
            ['id' => 'today', 'name' => __('labels.date_today')],
            ['id' => 'yesterday', 'name' => __('labels.date_yesterday')],
            ['id' => 'this_week', 'name' => __('labels.date_this_week')],
            ['id' => 'last_week', 'name' => __('labels.date_last_week')],
            ['id' => 'this_month', 'name' => __('labels.date_this_month')],
            ['id' => 'last_month', 'name' => __('labels.date_last_month')],
        ];
    }

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

    public function byRange($query)
    {
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
                $this->dateRange = 'today';
            }
        }
    }

    public function orders()
    {
        return Order::query()
            ->with('transactions')
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
            ->where('is_open', false)->orderBy('updated_at', 'desc')->paginate(20);
    }


    public function render()
    {
        return view('livewire.transactions.index', [
            'orders' => $this->orders(),
            'headers' => $this->headers(),
            'dateRanges' => $this->dateRanges(),
            'datePlugin' => $this->datePlugin(),
        ]);
    }
}
