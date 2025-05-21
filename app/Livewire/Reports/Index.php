<?php

namespace App\Livewire\Reports;

use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Arr;
use Livewire\Component;
use Mary\Traits\Toast;

class Index extends Component
{

    use Toast;

    public $yearId = 0;
    public $years = [];
    public $months = [];
    public array $yearSalesChart = [];
    public array $mostSoldChart = [];

    public function mount()
    {
        $year = date('Y');
        $years = range($year, $year - 10);
        $this->years = Arr::map($years, fn(int $value, int $key) => ['id' => $key, 'name' => $value]);
        $this->monthlySalesPerYear();
        $this->mostSoldProducts();
    }

    public function updatedYearId()
    {
        $this->monthlySalesPerYear();
    }

    public function monthlySalesPerYear()
    {
        $yearlySales = Transaction::selectRaw('MONTH(updated_at) as month, SUM(total) as total')
            ->whereYear('updated_at', $this->years[$this->yearId]['name'])
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
        return view('livewire.reports.index');
    }
}
