<?php

namespace App\Http\Controllers\PdfReports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;

class ByDateController extends Controller
{
    public function printPDF($date)
    {
        $data = [
            'title' => 'PDF Test',
            'date' => $date,
            'users' => 'PDF Content'
        ];
        $pdfInstance = app(PDF::class);
        $pdf = $pdfInstance->loadView('pdf-reports.by-date', $data);
        return $pdf->stream();
    }
}
