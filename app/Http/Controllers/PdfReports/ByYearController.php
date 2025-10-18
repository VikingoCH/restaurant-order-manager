<?php

namespace App\Http\Controllers\PdfReports;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class ByYearController extends Controller
{
    public function printPDF($date)
    {
        $transactions = $this->getData($date);
        $data = [
            'date' => $date,
            'transactions' => $transactions,
            'subtotal' => $this->getSubtotal($transactions),
            'total' => $this->getTotal($date)
        ];

        $pdfInstance = app(PDF::class);
        $pdf = $pdfInstance->loadView('pdf-reports.pdf', $data);
        return $pdf->stream();
    }

    private function getData($date)
    {
        return Transaction::whereYear('updated_at', $date)->with('transactionItems')->orderBy('updated_at', 'desc')->get();
    }

    private function getTotal($date)
    {
        return Transaction::whereYear('updated_at', $date)->selectRaw('SUM(total) as total_sum')->get();
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
