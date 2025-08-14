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
    private $total = 0;
    private $tax = 0;
    private $subtotal = 0;
    private $invoiceHeader = [];
    private $orderHeader = [];

    public function __construct($device)
    {
        $this->device = $device;
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
            $this->items[] = $this->orderItem($orderItem);
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

    public function addInvoiceItems($invoiceItems)
    {
        foreach ($invoiceItems as $invoiceItem)
        {
            $this->items[] = $this->invoiceItem($invoiceItem);
        }
    }

    public function invoiceTotals($invoiceItems)
    {
        $right_cols = 36;
        $left_cols = 9;
        $subtotal = 0;
        $tax = $this->tax();
        $invoiceTax = 0;

        foreach ($invoiceItems as $item)
        {
            $subtotal += $item->price * $item->quantity;
        }
        $this->total = str_pad('Total CHF', $right_cols) . str_pad(number_format($subtotal, 2), $left_cols, ' ', STR_PAD_LEFT);

        $invoiceTax = number_format($subtotal - ($subtotal / (1 + ($tax / 100))), 2);

        $this->tax = str_pad('MWST (' . $tax . ')', $right_cols) . str_pad($invoiceTax, $left_cols, ' ', STR_PAD_LEFT);

        $this->subtotal = str_pad('Nettobetrag', $right_cols) . str_pad(number_format($subtotal - $invoiceTax, 2), $left_cols, ' ', STR_PAD_LEFT);
    }

    public function printInvoice()
    {
        if ($this->device)
        {
            dd($this->device, $this->invoiceHeader, $this->items, $this->total, $this->tax, $this->subtotal);

            // Start the printer
            $connector = new NetworkPrintConnector($this->device->ip_address, $this->device->connection_port);
            $this->printer = new Printer($connector);


            //Cut & Close
            $this->printer->cut();
            $this->printer->close();
        }
        else
        {
            throw new \Exception('Printer device not set.');
        }
    }

    private function orderItem($item)
    {
        $qty_cols = 5;
        $name_cols = 40;

        if (strlen($item->menuItem->name) >= $name_cols)
        {
            $print_name = substr($item->menuItem->name, 0, $name_cols - 1);
        }
        else
        {
            $print_name = $item->menuItem->name;
        }
        if ($item->sides != "")
        {
            $print_sides = str_pad($item->sides, $name_cols + $qty_cols);
        }
        if ($item->remarks != "")
        {
            $print_remarks = str_pad($item->remarks, $name_cols + $qty_cols);
        }

        $print_name = str_pad($print_name, $name_cols);
        $print_qty = str_pad($item->quantity, $qty_cols, ' ', STR_PAD_LEFT);

        if (isset($print_sides) && isset($print_remarks))
        {
            return "$print_name$print_qty\n$print_sides\n$print_remarks\n";
        }
        else if (isset($print_sides) && !isset($print_remarks))
        {
            return "$print_name$print_qty\n$print_sides\n";
        }
        else if (isset($print_remarks) && !isset($print_sides))
        {
            return "$print_name$print_qty\n$print_remarks\n";
        }
        else
        {
            return "$print_name$print_qty\n";
        }
    }

    private function invoiceItem($item)
    {
        $name_cols = 25;
        $qty_cols = 3;
        $price_cols = 8;
        $total_cols = 9;

        if (strlen($item->menuItem->name) >= $name_cols)
        {
            $print_name = str_pad(substr(trim($item->menuItem->name), 0, $name_cols - 1), $name_cols);
        }
        else
        {
            $print_name = str_pad(trim($item->menuItem->name), $name_cols);
        }

        $print_qty = str_pad(trim($item->quantity), $qty_cols, ' ', STR_PAD_LEFT);

        $print_price = str_pad(trim($item->price), $price_cols, ' ', STR_PAD_LEFT);

        $print_total = str_pad(number_format($item->price * $item->quantity, 2), $total_cols, ' ', STR_PAD_LEFT);

        return "$print_name$print_qty$print_price$print_total\n";
    }

    private function separator($chr)
    {
        return str_repeat($chr, 47) . "\n";
    }
}
