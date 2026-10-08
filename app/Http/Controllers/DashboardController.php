<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $subscribedApps = [
            [
                'name' => 'Chama & Sacco Manager',
                'description' => 'Ushirika Bora Investment Group',
                'route' => 'apps.chama',
                'badge' => 'Active',
                'metric' => '48 Active Members',
                'accent' => '#dc2626',
            ],
            [
                'name' => 'Clinic & OPD Manager',
                'description' => 'Afya Bora Family Care Clinic',
                'route' => 'apps.clinic',
                'badge' => 'Active',
                'metric' => '14 In OPD Queue',
                'accent' => '#059669',
            ],
            [
                'name' => 'School & Academy Manager',
                'description' => 'Kilimani Premier Academy',
                'route' => 'apps.school',
                'badge' => 'Active',
                'metric' => 'Grade 1 - 9 CBC Records',
                'accent' => '#2563eb',
            ],
            [
                'name' => 'Property & Rent Manager',
                'description' => 'Riverside Heights Apartments',
                'route' => 'apps.property',
                'badge' => 'Active',
                'metric' => '96% Rent Collected',
                'accent' => '#7c3aed',
            ],
            [
                'name' => 'Smart Invoice & Quotations',
                'description' => 'Paperglow Kenya Operations',
                'route' => 'apps.invoice',
                'badge' => 'Active',
                'metric' => 'KES 4.2M This Month',
                'accent' => '#d97706',
            ],
        ];

        return view('pages.dashboard', [
            'subscribedApps' => $subscribedApps,
        ]);
    }
}
