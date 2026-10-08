<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the Paperglow Homepage (7 Ordered Sections).
     */
    public function index(): View
    {
        $featuredApps = [
            [
                'id' => 'paperglow-chama-manager',
                'name' => 'Paperglow Chama & Sacco Manager',
                'category' => 'Fintech & Groups',
                'description' => 'Automated monthly savings, M-Pesa statements, member welfare claims, and 3x share loan disbursement with zero math errors.',
                'icon' => 'banknotes',
                'badge' => 'Kenyan Favorite',
                'route' => 'apps.chama',
                'stats' => 'KES 42.8M Managed',
            ],
            [
                'id' => 'paperglow-clinic-manager',
                'name' => 'Paperglow Clinic & OPD Manager',
                'category' => 'Healthcare',
                'description' => 'Real-time patient triage, OPD queues, doctor consultation records, nurse vitals, and instant itemized billing.',
                'icon' => 'heart',
                'badge' => 'DirectAdmin Cloud',
                'route' => 'apps.clinic',
                'stats' => '2,400+ Patients',
            ],
            [
                'id' => 'paperglow-school-manager',
                'name' => 'Paperglow School Manager (CBC & 8-4-4)',
                'category' => 'Education',
                'description' => 'Term fee invoices, M-Pesa Paybill reconciliations, student CBC report cards, and parent SMS fee reminders.',
                'icon' => 'academic-cap',
                'badge' => 'MoE Compliant',
                'route' => 'apps.school',
                'stats' => '98.4% Fee Collection',
            ],
            [
                'id' => 'paperglow-property-manager',
                'name' => 'Paperglow Property & Rent Manager',
                'category' => 'Real Estate',
                'description' => 'Unit vacancy tracking, automated rent invoices, deposit ledgers, service charge reconciliations, and tenant portal.',
                'icon' => 'building-office-2',
                'badge' => 'Automated Arrears',
                'route' => 'apps.property',
                'stats' => '148 Units Tracked',
            ],
            [
                'id' => 'paperglow-invoice-generator',
                'name' => 'Paperglow Smart Invoice & Quotations',
                'category' => 'Accounting & Tax',
                'description' => 'Professional PDF quotations, 16% Kenyan VAT calculations, KRA PIN compliance, and one-click M-Pesa payment links.',
                'icon' => 'document-chart-bar',
                'badge' => 'KRA Compliant',
                'route' => 'apps.invoice',
                'stats' => 'KES 18.2M Invoiced',
            ],
            [
                'id' => 'paperglow-business-manager',
                'name' => 'Paperglow Business & POS Manager',
                'category' => 'Retail & Enterprise',
                'description' => 'Multi-branch point of sale, barcode scanning, stock level re-order alerts, and daily gross profit audits.',
                'icon' => 'shopping-cart',
                'badge' => 'Fast Checkout',
                'route' => 'apps.catalog',
                'stats' => '3,100+ Receipts/mo',
            ],
        ];

        $brandingShowcase = [
            [
                'title' => 'Custom Executive Polos & Uniforms',
                'subtitle' => 'High-density embroidery, premium 220gsm pique cotton',
                'turnaround' => '3-5 Working Days',
                'moq' => '10 pieces min',
            ],
            [
                'title' => 'Laser-Engraved Corporate Drinkware',
                'subtitle' => 'Matte double-walled 500ml vacuum flasks & travel mugs',
                'turnaround' => '48-Hour Rush Available',
                'moq' => '25 pieces min',
            ],
            [
                'title' => 'Branded Hardcover Executive Planners',
                'subtitle' => 'Blind debossed or gold foil leatherette notebooks',
                'turnaround' => '4-6 Working Days',
                'moq' => '20 pieces min',
            ],
            [
                'title' => 'Custom Retail Die-Cut Packaging',
                'subtitle' => 'Eco-friendly kraft mailer boxes with vibrant spot-UV print',
                'turnaround' => '5-7 Working Days',
                'moq' => '50 pieces min',
            ],
        ];

        return view('pages.home', [
            'featuredApps' => $featuredApps,
            'brandingShowcase' => $brandingShowcase,
        ]);
    }
}
