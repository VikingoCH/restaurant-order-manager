<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Printer;
use App\Printer\ReceiptPrinter;
// use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

trait PrintReceipts
{

    protected function printOrder($printer, $orderId, $orderItems)
    {
        $orderReceipt = new ReceiptPrinter($printer);
        $table = Order::find($orderId)->place->name ?? 'N/A';
        $orderReceipt->setOrderHeader($table, $orderId);
        $orderReceipt->addOrderItems($orderItems);
        $orderReceipt->printOrder();
        //TODO: Temporal return to test printing. To be deleted the $temp var.
        // $temp =  $orderReceipt->printOrder();
        // return $temp;
    }

    protected function printInvoice($orderId, $invoiceItems)
    {
        $printer = Printer::where('id', 1)->first();
        $invoiceReceipt = new ReceiptPrinter($printer);
        $invoiceReceipt->setInvoiceHeader($orderId);
        $invoiceReceipt->addInvoiceItems($invoiceItems);
        $invoiceReceipt->invoiceTotals($invoiceItems);
        $invoiceReceipt->printInvoice();
    }
}
