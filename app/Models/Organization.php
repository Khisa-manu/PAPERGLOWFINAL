<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'kra_pin',
        'email',
        'phone',
        'address',
        'city',
        'county',
        'country',
        'currency',
        'plan',
        'logo_url',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'tenant_id');
    }

    public function chamaMembers(): HasMany
    {
        return $this->hasMany(ChamaMember::class, 'organization_id');
    }

    public function clinicPatients(): HasMany
    {
        return $this->hasMany(ClinicPatient::class, 'organization_id');
    }
}
