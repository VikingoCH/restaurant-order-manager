<?php

namespace App\Http\Controllers\Receipts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mary\Traits\Toast;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

class PrintOrderController extends Controller
{
    use \App\Traits\Printing;
    use Toast;

    public function print($location, $orderID)
    {
        // Retrieve the printer settings on the location
        $printerIP = $this->printerIP($location);
        $printerConnector = $this->printerConnector($location);
        $printerPort = $this->printerPort($location);
        $storeInfo = $this->storeInfo($orderID);

        $printer = new ReceiptPrinter;
        $printer->init($printerConnector, $printerIP, $printerPort);

        $printer->setStore(
            $storeInfo['mid'],
            $storeInfo['store_name'],
            $storeInfo['store_address'],
            $storeInfo['store_phone'],
            $storeInfo['store_email'],
            $storeInfo['store_website']
        );
        $printer->addItem();
    }
}
