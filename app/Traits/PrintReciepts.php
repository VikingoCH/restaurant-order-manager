<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\Printer;
use App\Printer\ReceiptPrinter;
// use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

trait PrintReciepts
{
    use AppSettings;

    private function printer($printerId)
    {
        return Printer::where('id', $printerId)->first();
    }

    protected function storeInfo($id)
    {
        $storeInfo = $this->appSettings();
        return [
            'mid' => $id,
            'store_name' => $storeInfo->printer_store_name,
            'store_address' => $storeInfo->printer_store_address,
            'store_phone' => $storeInfo->printer_store_phone,
            'store_email' => $storeInfo->printer_store_email,
            'store_website' => $storeInfo->printer_store_website,
        ];
    }

    protected function printOrder($printer, $orderId, $orderItems)
    {
        $orderReceipt = new ReceiptPrinter($printer);
        $table = Order::find($orderId)->place->name ?? 'N/A';
        $orderReceipt->setOrderHeader($table, $orderId);
        $orderReceipt->addOrderItems($orderItems);
        //TODO: Temporal return to test printing. To be deleted the $temp var.
        $orderReceipt->printOrder();
        // $temp =  $orderReceipt->printOrder();
        // return $temp;
    }
}
