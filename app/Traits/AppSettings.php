<?php

namespace App\Traits;

use App\Models\AppSetting;

trait AppSettings
{
    protected function orderPrefix()
    {
        return $this->appSettings()->order_prefix;
    }

    protected function quickOrderName()
    {
        return $this->appSettings()->quick_order_name;
    }

    protected function tax()
    {
        return $this->appSettings()->tax;
    }

    protected function rowsPerPage()
    {
        return $this->appSettings()->rows_per_page;
    }

    protected function defaultPrinter()
    {
        return $this->appSettings()->default_printer;
    }

    private function appSettings()
    {
        return AppSetting::orderBy('created_at', 'desc')->first();
    }
}
