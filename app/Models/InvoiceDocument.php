<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDocument extends Model
{
    protected $fillable = [
        'organization_id',
        'invoice_number',
        'document_type', // Tax Invoice, Proforma Invoice, Quotation, Delivery Note
        'client_name',
        'client_email',
        'client_kra_pin',
        'client_address',
        'issue_date',
        'due_date',
        'line_items_data',
        'subtotal_kes',
        'vat_amount_kes', // 16% Kenyan VAT
        'total_kes',
        'payment_status', // Draft, Sent, Paid, Overdue
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'line_items_data' => 'array',
        'subtotal_kes' => 'decimal:2',
        'vat_amount_kes' => 'decimal:2',
        'total_kes' => 'decimal:2',
    ];
}
