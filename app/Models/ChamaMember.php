<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChamaMember extends Model
{
    protected $fillable = [
        'organization_id',
        'membership_number',
        'full_name',
        'email',
        'phone',
        'national_id',
        'residential_area',
        'occupation',
        'next_of_kin_name',
        'next_of_kin_phone',
        'next_of_kin_relationship',
        'role', // Chairperson, Secretary, Treasurer, Member
        'status', // active, inactive, suspended
        'date_joined',
        'total_contributions_kes',
        'current_loan_balance_kes',
        'welfare_contributions_kes',
        'shares_units',
        'notes',
    ];

    protected $casts = [
        'date_joined' => 'date',
        'total_contributions_kes' => 'decimal:2',
        'current_loan_balance_kes' => 'decimal:2',
        'welfare_contributions_kes' => 'decimal:2',
        'shares_units' => 'integer',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(ChamaContribution::class, 'member_id');
    }

    public function loans(): HasMany
    {
        return $this->hasMany(ChamaLoan::class, 'member_id');
    }
}
