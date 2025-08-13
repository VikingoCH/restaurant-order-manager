<?php

namespace App\Printer;

use App\Traits\AppSettings;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class ReceiptPrinter
{
    use AppSettings;


    private $printer;
    private $device;
    private $items = [];
    private $invoiceHeader = [];
    private $orderHeader = [];

    /**
     * Create a new class instance.
     */
    public function __construct($device)
    {
        $this->device = $device;
    }

    public function setInvoiceHeader($id)
    {
        $storeInfo = $this->AppSettings();
        $this->invoiceHeader = [
            'order_id' => $id,
            'store_name' => $storeInfo->printer_store_name,
            'store_address' => $storeInfo->printer_store_address,
            'store_phone' => $storeInfo->printer_store_phone,
            'store_email' => $storeInfo->printer_store_email,
            'store_website' => $storeInfo->printer_store_website,
        ];
    }

    public function setOrderHeader($table, $id)
    {
        $this->orderHeader = [
            'table' => $table,
            'order_id' => $id,
        ];
    }

    public function addOrderItems($orderItems)
    {
        foreach ($orderItems as $orderItem)
        {
            $this->items[] = $this->orderItem($orderItem->menuItem->name, $orderItem->quantity);
        }
    }


    public function printOrder()
    {
        if ($this->device)
        {
            // Start the printer
            $connector = new NetworkPrintConnector($this->device->ip_address, $this->device->connection_port);
            $this->printer = new Printer($connector);

            //Initialize the printer
            $this->printer->initialize();
            $this->printer->setPrintLeftMargin(1);

            //Header
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $this->printer->text($this->orderHeader['order_id'] . "\n");
            $this->printer->text($this->orderHeader['table'] . "\n");
            $this->printer->selectPrintMode();
            $this->printer->setJustification(Printer::JUSTIFY_RIGHT);
            $this->printer->text(date('j F Y H:i:s'));
            $this->printer->feed();

            //Items
            $this->printer->text($this->separator('-'));
            $this->printer->setJustification(Printer::JUSTIFY_LEFT);
            $this->printer->feed();
            foreach ($this->items as $item)
            {
                $this->printer->text($item);
            }
            $this->printer->feed();
            $this->printer->text($this->separator('-'));
            $this->printer->feed(2);

            //Cut & Close
            $this->printer->cut();
            $this->printer->close();
        }
        else
        {
            throw new \Exception('Printer device not set.');
        }
    }

    private function orderItem($name, $qty)
    {
        $right_cols = 5;
        $left_cols = 40;

        $print_name = str_pad($name, $left_cols);
        $print_qty = str_pad($qty, $right_cols, ' ', STR_PAD_LEFT);

        return "$print_name$print_qty\n";
    }

    private function separator($chr)
    {
        return str_repeat($chr, 47) . "\n";
    }
}
