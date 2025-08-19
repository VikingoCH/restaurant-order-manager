<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Place;
use App\Models\Printer;
use App\Printer\ReceiptPrinter;
// use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

trait PrintReceipts
{

    protected function printOrder($printer, $orderId, $orderItems)
    {
        $order = Order::with('place')->find($orderId);
        // $table = Place::find($order->place_id)->location->name;

        $orderReceipt = new ReceiptPrinter($printer);
        $orderReceipt->setOrderHeader($order->table, $order->number);
        $orderReceipt->addOrderItems($orderItems);
        $orderReceipt->printOrder();
        //TODO: Temporal return to test printing. To be deleted the $temp var.
        // $temp =  $orderReceipt->printOrder();
        // return $temp;
    }

    protected function printInvoice($orderId, $invoiceItems)
    {
        $order = Order::find($orderId);
        $printer = Printer::where('id', 1)->first();
        $invoiceReceipt = new ReceiptPrinter($printer);
        $invoiceReceipt->setInvoiceHeader($order->number);
        $invoiceReceipt->addInvoiceItems($invoiceItems);
        $invoiceReceipt->invoiceTotals($order);
        $invoiceReceipt->printInvoice();
    }

    protected function printCashClose($items)
    {
        // dd($items);
        $printer = Printer::where('id', 1)->first();
        $invoiceReceipt = new ReceiptPrinter($printer);
        $invoiceReceipt->setCashCloseHeader();
        $invoiceReceipt->addCashCloseItems($items);
        $invoiceReceipt->printCashClose();
    }
}
