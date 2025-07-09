<?php

namespace App\Http\Controllers\PdfReports;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
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

    private function getData($date)
    {
        $data = Transaction::whereDate('updated_at', $date)->get();
        // Fetch data based on the date
        // This is a placeholder for actual data fetching logic
        return [
            'title' => 'PDF Report for ' . $date,
            'date' => $date,
            'users' => ['User1', 'User2', 'User3'] // Example data
        ];
    }
}
