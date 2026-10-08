<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChamaContribution extends Model
{
    protected $fillable = [
        'organization_id',
        'member_id',
        'month',
        'year',
        'amount_kes',
        'welfare_kes',
        'penalty_kes',
        'total_paid_kes',
        'payment_date',
        'payment_method', // mpesa, bank_transfer, cash
        'transaction_reference',
        'recorded_by',
        'status', // confirmed, pending_verification
    ];

    protected $casts = [
        'amount_kes' => 'decimal:2',
        'welfare_kes' => 'decimal:2',
        'penalty_kes' => 'decimal:2',
        'total_paid_kes' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(ChamaMember::class, 'member_id');
    }
}
