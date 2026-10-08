<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyListing extends Model
{
    protected $fillable = [
        'organization_id',
        'property_code',
        'name',
        'type', // Commercial, Residential, Industrial
        'location',
        'county',
        'total_units',
        'occupied_units',
        'monthly_rent_kes',
        'monthly_service_charge_kes',
        'status', // Active, Maintenance
    ];

    protected $casts = [
        'monthly_rent_kes' => 'decimal:2',
        'monthly_service_charge_kes' => 'decimal:2',
        'total_units' => 'integer',
        'occupied_units' => 'integer',
    ];
}
