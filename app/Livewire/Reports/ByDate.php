<?php

namespace App\Livewire\Reports;

use Livewire\Component;

class ByDate extends Component
{
    public $date;

    public function render()
    {
        return view('livewire.reports.by-date');
    }
}
