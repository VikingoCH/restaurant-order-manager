<?php

namespace App\Livewire\Reports;

use Livewire\Component;

class ByYear extends Component
{
    public $year;

    public function render()
    {
        return view('livewire.reports.by-year');
    }
}
