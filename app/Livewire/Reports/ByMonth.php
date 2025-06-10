<?php

namespace App\Livewire\Reports;

use Livewire\Component;

class ByMonth extends Component
{
    public $date;

    public function render()
    {
        return view('livewire.reports.by-month');
    }
}
