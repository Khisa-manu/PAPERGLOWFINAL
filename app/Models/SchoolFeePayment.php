<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolFeePayment extends Model
{
    protected $fillable = [
        'organization_id',
        'student_id',
        'receipt_number',
        'term', // Term 1, Term 2, Term 3
        'academic_year',
        'amount_kes',
        'payment_method', // mpesa_paybill, bank_deposit, cash
        'transaction_reference',
        'payment_date',
        'recorded_by',
        'notes',
    ];

    protected $casts = [
        'amount_kes' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(SchoolStudent::class, 'student_id');
    }
}
