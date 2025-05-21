<?php

namespace App\Livewire\Reports;

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

    public function mount()
    {
        $year = date('Y');
        $years = range($year, $year - 10);
        // dd($years);
        // $this->years = Arr::map($years, function (int $value, int $key)
        // {
        //     return ['id' => $key, 'name' => $value];
        // });
        $this->years = Arr::map($years, fn(int $value, int $key) => ['id' => $key, 'name' => $value]);
        $this->monthlySalesPerYear();
    }

    public function updatedYearId()
    {
        // dd($this->years[$this->yearId]['name'], $this->yearId);
        $this->success('year Updated');
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


    public function render()
    {
        return view('livewire.reports.index');
    }
}
