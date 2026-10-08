<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolStudent extends Model
{
    protected $fillable = [
        'organization_id',
        'admission_number',
        'full_name',
        'class_name',
        'stream',
        'parent_name',
        'parent_phone',
        'parent_email',
        'total_fee_due_kes',
        'total_fee_paid_kes',
        'fee_balance_kes',
        'status', // Active, Transferred, Alumni
    ];

    protected $casts = [
        'total_fee_due_kes' => 'decimal:2',
        'total_fee_paid_kes' => 'decimal:2',
        'fee_balance_kes' => 'decimal:2',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(SchoolFeePayment::class, 'student_id');
    }
}
