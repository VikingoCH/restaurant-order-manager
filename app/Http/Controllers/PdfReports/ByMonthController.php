<?php

namespace App\Http\Controllers\PdfReports;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class ByMonthController extends Controller
{
    public function printPDF($date)
    {
        $year = substr($date, strrpos($date, '-') + 1);
        $month = substr($date, 0, 2);
        // dd($year, $month);
        $transactions = $this->getData($month, $year);
        $data = [
            'date' => $date,
            'transactions' => $transactions,
            'subtotal' => $this->getSubtotal($transactions),
            'total' => $this->getTotal($month, $year)
        ];

        $pdfInstance = app(PDF::class);
        $pdf = $pdfInstance->loadView('pdf-reports.pdf', $data);
        return $pdf->stream();
    }

    private function getData($month, $year)
    {

        return Transaction::whereMonth('updated_at', $month)->whereYear('updated_at', $year)->with('transactionItems')->orderBy('updated_at', 'desc')->get();
    }

    private function getTotal($month, $year)
    {
        return Transaction::whereMonth('updated_at', $month)->whereYear('updated_at', $year)->selectRaw('SUM(total) as total_sum')->get();
    }

    private function getSubtotal($transactions)
    {
        $subtotal = [];
        foreach ($transactions as $transaction)
        {
            $subtotal[$transaction->id] = 0;
            foreach ($transaction->transactionItems as $item)
            {
                $subtotal[$transaction->id] += number_format($item->quantity * $item->price, 2);
            }
        }
        return $subtotal;
    }
}
