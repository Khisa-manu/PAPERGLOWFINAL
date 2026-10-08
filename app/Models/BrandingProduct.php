<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandingProduct extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'category', // Apparel, Stationery, Corporate Gift, Signage, Packaging
        'base_price_kes',
        'min_order_qty',
        'turnaround_days',
        'customization_options', // embroidery, screen_print, uv_dtf, laser_engraving
        'description',
        'image_url',
        'active',
    ];

    protected $casts = [
        'base_price_kes' => 'decimal:2',
        'min_order_qty' => 'integer',
        'turnaround_days' => 'integer',
        'customization_options' => 'array',
        'active' => 'boolean',
    ];
}
