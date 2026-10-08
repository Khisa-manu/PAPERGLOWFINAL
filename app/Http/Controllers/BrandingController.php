<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandingController extends Controller
{
    public function index(): View
    {
        $products = [
            [
                'id' => 'polo-executive',
                'name' => 'Corporate Executive Pique Polo Shirts',
                'category' => 'Apparel',
                'price_kes' => 1450,
                'min_qty' => 10,
                'colors' => ['Navy Blue', 'Paperglow Red', 'Charcoal', 'Pure White'],
                'features' => ['High-density 3D chest embroidery', '220 GSM breathable combed cotton', 'Ribbed collar and cuffs'],
            ],
            [
                'id' => 'flask-vacuum',
                'name' => 'Matte Thermal Vacuum Flask (500ml)',
                'category' => 'Drinkware',
                'price_kes' => 1250,
                'min_qty' => 20,
                'colors' => ['Matte Black', 'Brushed Steel', 'Forest Green', 'Crimson Red'],
                'features' => ['Precision fiber laser engraving', '12-hour hot / 24-hour cold retention', 'BPA-free 304 food-grade stainless steel'],
            ],
            [
                'id' => 'notebook-executive',
                'name' => 'Hardcover PU Leatherette Executive Planner',
                'category' => 'Stationery',
                'price_kes' => 950,
                'min_qty' => 15,
                'colors' => ['Navy', 'Tan Brown', 'Black', 'Burgundy'],
                'features' => ['Blind debossed or gold-foil logo', '192 ruled ivory pages with ribbon marker', 'Expandable inner document pocket'],
            ],
            [
                'id' => 'boxes-mailer',
                'name' => 'Custom Corrugated Die-Cut Mailer Boxes',
                'category' => 'Packaging',
                'price_kes' => 220,
                'min_qty' => 50,
                'colors' => ['Natural Kraft', 'Bleached White', 'Full Color CMYK'],
                'features' => ['High-impact soy-based spot UV printing', 'Self-locking tuck-top design', '100% recyclable biodegradable board'],
            ],
        ];

        return view('pages.branding', [
            'products' => $products,
        ]);
    }
}
