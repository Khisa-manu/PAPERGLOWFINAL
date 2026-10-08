<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClinicPatient extends Model
{
    protected $fillable = [
        'organization_id',
        'patient_number', // OPD-00124
        'full_name',
        'phone',
        'email',
        'gender', // Male, Female, Other
        'age',
        'date_of_birth',
        'id_number',
        'blood_group',
        'allergies',
        'emergency_contact_name',
        'emergency_contact_phone',
        'outstanding_balance_kes',
        'total_visits',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'outstanding_balance_kes' => 'decimal:2',
        'total_visits' => 'integer',
        'age' => 'integer',
    ];

    public function visits(): HasMany
    {
        return $this->hasMany(ClinicVisit::class, 'patient_id');
    }
}
