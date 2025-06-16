<?php

namespace App\Livewire\Reports;

use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Mary\Traits\Toast;

class Index extends Component
{

    use Toast;

    public $chartYear = 0;
    public $years = [];
    // public $months = [];
    public array $yearSalesChart = [];
    public array $mostSoldChart = [];
    public $reportByDate;
    public $urlDate;
    public $reportByMonth;
    public $reportYear = 0;
    public $urlYear;

    public function mount()
    {
        $year = date('Y');
        $years = range($year, $year - 10);
        $this->years = Arr::map($years, fn(int $value, int $key) => ['id' => $key, 'name' => $value]);
        $this->monthlySalesPerYear();
        $this->mostSoldProducts();
        $this->reportByDate = now()->format('Y/m/d');
        $this->urlDate = now()->format('Y-m-d');
        $this->reportByMonth = now()->format('m-Y');
        $this->urlYear = now()->format('Y');
        // $this->reportDate = today()->format('Y/m/d');
    }

    public function reportByDateCalendar()
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
            'altFormat' => 'Y/m/d',
        ];
    }

    public function updatedReportByDate($value)
    {
        $this->urlDate = Carbon::createFromFormat('Y-m-d H:s', $value)->format('Y-m-d');
    }

    public function updatedReportYear($value)
    {
        $this->urlYear = $this->years[$value]['name'];
    }

    public function reportByMonthCalendar()
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
                        'dateFormat' => 'm-Y',
                        'altFormat' => 'F Y',
                    ],
                ],
            ],
        ];
    }

    public function updatedChartYear()
    {
        $this->monthlySalesPerYear();
    }

    public function monthlySalesPerYear()
    {
        $yearlySales = Transaction::selectRaw('MONTH(updated_at) as month, SUM(total) as total')
            ->whereYear('updated_at', $this->years[$this->chartYear]['name'])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $this->yearSalesChart = [
            'type' => 'bar',
            'options' => [
                'plugins' => [
                    'legend' => [
                        'display' => false,
                    ]
                ]
            ],
            'data' => [
                'labels' => collect($yearlySales->pluck('month')->toArray())->mapWithKeys(fn($item, $key) => [$key => trans("app.months.{$item}")]),
                'datasets' => [
                    [
                        'label' => __('labels.total_sales'),
                        'data' => $yearlySales->pluck('total')->toArray(),
                    ]
                ]
            ]
        ];
    }

    public function mostSoldProducts()
    {
        $mostSoldProducts = OrderItem::with('menuItem')
            ->selectRaw('menu_item_id, SUM(quantity) as total')
            ->groupBy('menu_item_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item)
            {
                return [
                    'name' => $item->menuItem->name,
                    'total' => $item->total,
                ];
            });
        // ->toArray();
        // dd($mostSoldProducts->pluck('name')->toArray());

        $this->mostSoldChart = [
            'type' => 'pie',
            'options' => [
                'plugins' => [
                    'legend' => [
                        'position' => 'right',
                    ]
                ]
            ],
            'data' => [
                'labels' => $mostSoldProducts->pluck('name')->toArray(),
                'datasets' => [
                    [
                        'label' => __('labels.total'),
                        'data' => $mostSoldProducts->pluck('total')->toArray(),
                    ]
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.reports.index', [
            'byDateCalendar' => $this->reportByDateCalendar(),
            'byMonthCalendar' => $this->reportByMonthCalendar(),
        ]);
    }
}
