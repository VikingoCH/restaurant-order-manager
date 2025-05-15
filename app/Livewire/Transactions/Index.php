<?php

namespace App\Livewire\Transactions;

use App\Models\Order;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public array $expanded = [];
    public $dateRange = 'this_year';
    public $monthYear = '';
    public $showing = '';

    public function mount()
    {
        $this->showing = __('labels.date_range.this_year');
    }

    public function headers(): array
    {
        return [
            ['key' => 'number', 'label' => __('labels.number')],
            ['key' => 'order.number', 'label' => __('labels.order_number')],
            // ['key' => 'total', 'label' => __('labels.sub_total'), 'format' => ['currency', '2.\'', 'CHF ']],
            ['key' => 'discount', 'label' => __('labels.discount'), 'format' => ['currency', '2.\'', 'CHF ']],
            ['key' => 'tip', 'label' => __('labels.tip'), 'format' => ['currency', '2.\'', 'CHF ']],
            ['key' => 'tax', 'label' => __('labels.tax'), 'format' => ['currency', '2.\'', 'CHF ']],
            ['key' => 'total', 'label' => __('labels.total'), 'format' => ['currency', '2.\'', 'CHF ']],
            // ['key' => 'created_at', 'label' => __('labels.open_at'), 'format' => ['date', 'Y/m/d (H:i)']],
            ['key' => 'updated_at', 'label' => __('labels.date'), 'format' => ['date', 'Y/m/d (H:i)']],
        ];
    }

    public function dateRanges(): array
    {
        return [
            ['id' => 'this_year', 'name' => __('labels.date_range.this_year')],
            ['id' => 'today', 'name' => __('labels.date_range.today')],
            ['id' => 'yesterday', 'name' => __('labels.date_range.yesterday')],
            ['id' => 'this_week', 'name' => __('labels.date_range.this_week')],
            ['id' => 'this_month', 'name' => __('labels.date_range.this_month')],
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
                $this->dateRange = 'today';
            }
        }
    }

    public function transactions()
    {
        return Transaction::query()
            ->with('order')
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
                // elseif ($this->dateRange === 'last_week')
                // {
                //     $query->whereBetween('updated_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                // }
                elseif ($this->dateRange === 'this_month')
                {
                    $query->whereMonth('updated_at', now()->month);
                }
                // elseif ($this->dateRange === 'last_month')
                // {
                //     $query->whereMonth('updated_at', now()->subMonth()->month);
                // }
                elseif ($this->dateRange === 'this_year')
                {
                    $query->whereYear('updated_at', now()->year);
                }
                elseif ($this->monthYear)
                {
                    $year = substr($this->monthYear, strrpos($this->monthYear, '.') + 1);
                    $month = substr($this->monthYear, 0, 2);
                    $query->whereMonth('updated_at', $month)->whereYear('updated_at', $year);
                }
            })
            ->orderBy('updated_at', 'desc')->paginate(5);
    }

    public function total()
    {
        $total = Transaction::query()
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
                // elseif ($this->dateRange === 'last_week')
                // {
                //     $query->whereBetween('updated_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                // }
                elseif ($this->dateRange === 'this_month')
                {
                    $query->whereMonth('updated_at', now()->month);
                }
                // elseif ($this->dateRange === 'last_month')
                // {
                //     $query->whereMonth('updated_at', now()->subMonth()->month);
                // }
                elseif ($this->dateRange === 'this_year')
                {
                    $query->whereYear('updated_at', now()->year);
                }
                elseif ($this->monthYear)
                {
                    $year = substr($this->monthYear, strrpos($this->monthYear, '.') + 1);
                    $month = substr($this->monthYear, 0, 2);
                    $query->whereMonth('updated_at', $month)->whereYear('updated_at', $year);
                }
            })
            ->selectRaw('SUM(total) as total_sum')
            ->get();

        if ($total->isEmpty())
        {
            return 0;
        }

        return $total[0]->total_sum;
    }


    public function render()
    {
        return view('livewire.transactions.index', [
            'total' => $this->total(),
            'transactions' => $this->transactions(),
            'headers' => $this->headers(),
            'dateRanges' => $this->dateRanges(),
            'datePlugin' => $this->datePlugin(),
        ]);
    }
}
