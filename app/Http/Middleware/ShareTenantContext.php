<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;

class ShareTenantContext
{
    /**
     * Handle an incoming request and share tenant context with all Blade views.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Global paperglow tenant configuration
        $currentTenant = [
            'name' => 'Paperglow Enterprise Kenya',
            'email' => 'sales@paperglow.co.ke',
            'phone' => '+254 700 123 456',
            'county' => 'Nairobi',
            'country' => 'Kenya',
            'currency' => 'KES',
            'currency_symbol' => 'KES ',
            'primary_color' => '#DC2626', // Paperglow signature red
        ];

        View::share('tenant', $currentTenant);
        View::share('appName', config('app.name', 'Paperglow'));

        return $next($request);
    }
}
