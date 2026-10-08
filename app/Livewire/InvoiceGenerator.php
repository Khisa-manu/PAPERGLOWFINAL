<?php

namespace App\Livewire;

use Livewire\Component;

class InvoiceGenerator extends Component
{
    public string $invoiceNumber = 'INV-2026-0842';
    public string $documentType = 'Tax Invoice'; // Tax Invoice, Quotation, Proforma
    public string $clientName = 'Safaricom Telecommunications PLC';
    public string $clientKraPin = 'P051123456Z';
    public string $clientEmail = 'procurement@safaricom.co.ke';
    public string $clientAddress = 'Waiyaki Way, Westlands, Nairobi';
    public string $issueDate = '';
    public string $dueDate = '';
    public bool $includeVat = true;
    public float $discountPercent = 0.0;
    public string $notes = 'Payment terms: Net 30 days. Payments via M-Pesa Paybill 247247 or NCBA Bank Kenya.';

    public array $items = [
        [
            'description' => 'Custom Executive Embroidered Polo Shirts (220 GSM)',
            'quantity' => 50,
            'unit_price' => 1450,
        ],
        [
            'description' => 'Matte Thermal Vacuum Flasks with Fiber Laser Engraving',
            'quantity' => 30,
            'unit_price' => 1250,
        ],
        [
            'description' => 'Paperglow Business POS Cloud License (Annual Subscription)',
            'quantity' => 1,
            'unit_price' => 32000,
        ],
    ];

    public function mount(): void
    {
        $this->issueDate = date('Y-m-d');
        $this->dueDate = date('Y-m-d', strtotime('+30 days'));
    }

    public function addItem(): void
    {
        $this->items[] = [
            'description' => 'New line item description',
            'quantity' => 1,
            'unit_price' => 1000,
        ];
    }

    public function removeItem(int $index): void
    {
        if (count($this->items) > 1) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }

    public function render()
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += ($item['quantity'] * $item['unit_price']);
        }

        $discountAmount = $subtotal * ($this->discountPercent / 100);
        $taxableAmount = $subtotal - $discountAmount;
        $vatAmount = $this->includeVat ? ($taxableAmount * 0.16) : 0;
        $total = $taxableAmount + $vatAmount;

        return view('livewire.invoice-generator', [
            'subtotal' => $subtotal,
            'discountAmount' => $discountAmount,
            'vatAmount' => $vatAmount,
            'total' => $total,
        ]);
    }
}
