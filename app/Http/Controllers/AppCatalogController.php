<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AppCatalogController extends Controller
{
    protected array $catalog = [
        [
            'id' => 'paperglow-chama-manager',
            'slug' => 'chama-manager',
            'name' => 'Paperglow Chama & Sacco Manager',
            'category' => 'Finance & Groups',
            'price_kes' => 2500,
            'billing' => 'month',
            'description' => 'Comprehensive management system for investment groups, merry-go-rounds, and SACCOs.',
            'features' => ['Member ledger & shares', 'M-Pesa reconciliation', 'Loan disbursement (3x savings)', 'Welfare & bereavement fund', 'PDF statements'],
            'route' => 'apps.chama',
        ],
        [
            'id' => 'paperglow-clinic-manager',
            'slug' => 'clinic-manager',
            'name' => 'Paperglow Clinic & OPD Manager',
            'category' => 'Healthcare',
            'price_kes' => 4500,
            'billing' => 'month',
            'description' => 'Outpatient department manager, patient queuing, vitals capture, and medical billing.',
            'features' => ['Patient registry & OPD IDs', 'Triage & vital signs', 'Consultations & clinical notes', 'Prescriptions & pharmacy dispense', 'Cash & NHIF/SHA receipts'],
            'route' => 'apps.clinic',
        ],
        [
            'id' => 'paperglow-school-manager',
            'slug' => 'school-manager',
            'name' => 'Paperglow School & Academy Manager',
            'category' => 'Education',
            'price_kes' => 5000,
            'billing' => 'term',
            'description' => 'Complete academic and fee administration for CBC and 8-4-4 schools.',
            'features' => ['Student registration & classes', 'Term fee invoice generation', 'M-Pesa Paybill auto-matching', 'Report cards & CBC rubrics', 'Parent SMS reminders'],
            'route' => 'apps.school',
        ],
        [
            'id' => 'paperglow-property-manager',
            'slug' => 'property-manager',
            'name' => 'Paperglow Property & Rent Manager',
            'category' => 'Real Estate',
            'price_kes' => 3500,
            'billing' => 'month',
            'description' => 'Commercial and residential tenancy tracking, rent roll, and maintenance logs.',
            'features' => ['Multi-building property directory', 'Tenant leases & deposit registry', 'Rent collection & arrears SMS', 'Service charge reconciliation', 'Landlord remittance reports'],
            'route' => 'apps.property',
        ],
        [
            'id' => 'paperglow-invoice-generator',
            'slug' => 'invoice-generator',
            'name' => 'Paperglow Smart Invoice & Quotations',
            'category' => 'Accounting & Tax',
            'price_kes' => 1200,
            'billing' => 'month',
            'description' => 'KRA PIN compliant tax invoices, quotations, and delivery notes.',
            'features' => ['16% VAT auto-calculation', 'KRA PIN compliance format', 'Custom company branding & stamp', 'PDF export & print layout', 'M-Pesa payment link generation'],
            'route' => 'apps.invoice',
        ],
        [
            'id' => 'paperglow-business-manager',
            'slug' => 'business-manager',
            'name' => 'Paperglow Business POS & Stock Manager',
            'category' => 'Retail & Enterprise',
            'price_kes' => 3000,
            'billing' => 'month',
            'description' => 'Point of sale and inventory manager for retail shops, supermarkets, and wholesale.',
            'features' => ['Barcode scanning & receipt printing', 'Low-stock automated alerts', 'Supplier purchase orders', 'Daily gross profit audit', 'Multi-cashier access control'],
            'route' => 'apps.catalog',
        ],
    ];

    public function index(Request $request): View
    {
        $category = $request->query('category');
        $apps = $this->catalog;

        if ($category && $category !== 'all') {
            $apps = array_filter($apps, fn($a) => strtolower($a['category']) === strtolower($category));
        }

        return view('pages.catalog', [
            'apps' => $apps,
            'selectedCategory' => $category ?? 'all',
        ]);
    }

    public function show(string $slug): View
    {
        $app = collect($this->catalog)->firstWhere('slug', $slug) ?? $this->catalog[0];

        return view('pages.app-detail', [
            'app' => $app,
        ]);
    }
}
