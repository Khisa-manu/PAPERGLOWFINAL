<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClinicVisit extends Model
{
    protected $fillable = [
        'organization_id',
        'visit_number',
        'patient_id',
        'doctor_name',
        'visit_date',
        'chief_complaint',
        'history_present_illness',
        'systolic_bp',
        'diastolic_bp',
        'pulse_bpm',
        'temperature_c',
        'weight_kg',
        'clinical_diagnosis',
        'treatment_plan',
        'prescriptions_data',
        'total_cost_kes',
        'status', // in_consultation, completed, billed
    ];

    protected $casts = [
        'visit_date' => 'date',
        'prescriptions_data' => 'array',
        'total_cost_kes' => 'decimal:2',
        'temperature_c' => 'decimal:1',
        'weight_kg' => 'decimal:1',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(ClinicPatient::class, 'patient_id');
    }
}
