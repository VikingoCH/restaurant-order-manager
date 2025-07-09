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
        // $datos = $this->getData($date);
        // dd($datos);
        $transactions = $this->getData($date);
        $data = [
            'date' => $date,
            'transactions' => $transactions,
            'subtotal' => $this->getSubtotal($transactions),
            'total' => $this->getTotal($date)
        ];
        // dd($data);


        $pdfInstance = app(PDF::class);
        $pdf = $pdfInstance->loadView('pdf-reports.by-date', $data);
        return $pdf->stream();
    }

    private function getData($date)
    {
        return Transaction::whereDate('updated_at', $date)->with('transactionItems')->orderBy('updated_at', 'desc')->get();
    }

    private function getTotal($date)
    {
        return Transaction::whereDate('updated_at', $date)->selectRaw('SUM(total) as total_sum')->get();
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
