<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChamaLoan extends Model
{
    protected $fillable = [
        'organization_id',
        'member_id',
        'loan_number',
        'loan_type', // Emergency Loan, Development Loan, Business Booster
        'principal_amount_kes',
        'interest_rate_percent',
        'interest_amount_kes',
        'total_repayable_kes',
        'duration_months',
        'monthly_installment_kes',
        'application_date',
        'disbursement_date',
        'amount_repaid_kes',
        'balance_kes',
        'status', // pending_approval, approved, active, cleared, defaulted
        'purpose',
        'guarantors_data',
    ];

    protected $casts = [
        'principal_amount_kes' => 'decimal:2',
        'interest_rate_percent' => 'decimal:2',
        'interest_amount_kes' => 'decimal:2',
        'total_repayable_kes' => 'decimal:2',
        'monthly_installment_kes' => 'decimal:2',
        'amount_repaid_kes' => 'decimal:2',
        'balance_kes' => 'decimal:2',
        'guarantors_data' => 'array',
        'application_date' => 'date',
        'disbursement_date' => 'date',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(ChamaMember::class, 'member_id');
    }
}
