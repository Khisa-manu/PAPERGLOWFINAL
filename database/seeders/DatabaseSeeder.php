<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Organization;
use App\Models\User;
use App\Models\ChamaMember;
use App\Models\ClinicPatient;
use App\Models\SchoolStudent;
use App\Models\PropertyListing;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the Paperglow production database on DirectAdmin / Shujaa Host.
     */
    public function run(): void
    {
        // 1. Create Default Master Organization
        $org = Organization::create([
            'name' => 'Paperglow Enterprise Kenya',
            'slug' => 'paperglow-kenya',
            'kra_pin' => 'P051982736M',
            'email' => 'sales@paperglow.co.ke',
            'phone' => '+254 700 123 456',
            'city' => 'Nairobi',
            'county' => 'Nairobi',
            'country' => 'Kenya',
            'currency' => 'KES',
            'plan' => 'enterprise',
            'active' => true,
        ]);

        // 2. Superadmin User
        User::create([
            'tenant_id' => $org->id,
            'name' => 'Paperglow Administrator',
            'email' => 'admin@paperglow.co.ke',
            'password' => Hash::make('Admin2026!SecureDirectAdmin'),
            'role' => 'superadmin',
            'phone' => '+254 700 123 456',
            'active' => true,
        ]);

        // 3. Seed Chama Members
        ChamaMember::create([
            'organization_id' => $org->id,
            'membership_number' => 'UB-001',
            'full_name' => 'Wanjiku Kamau',
            'phone' => '+254 712 345 678',
            'role' => 'Chairperson',
            'status' => 'active',
            'date_joined' => '2022-01-15',
            'total_contributions_kes' => 280000,
            'current_loan_balance_kes' => 0,
            'welfare_contributions_kes' => 14000,
            'shares_units' => 28,
        ]);

        ChamaMember::create([
            'organization_id' => $org->id,
            'membership_number' => 'UB-002',
            'full_name' => 'Brian Ochieng',
            'phone' => '+254 723 456 789',
            'role' => 'Treasurer',
            'status' => 'active',
            'date_joined' => '2022-02-10',
            'total_contributions_kes' => 310000,
            'current_loan_balance_kes' => 75000,
            'welfare_contributions_kes' => 14000,
            'shares_units' => 31,
        ]);

        // 4. Seed Clinic Patients
        ClinicPatient::create([
            'organization_id' => $org->id,
            'patient_number' => 'OPD-2026-089',
            'full_name' => 'Wanjiku Mwangi',
            'phone' => '+254 721 889 900',
            'gender' => 'Female',
            'age' => 34,
            'outstanding_balance_kes' => 0,
            'total_visits' => 4,
        ]);

        // 5. Seed School Students
        SchoolStudent::create([
            'organization_id' => $org->id,
            'admission_number' => 'PA-2026-104',
            'full_name' => 'Emmanuel Kiprotich',
            'class_name' => 'Grade 7',
            'parent_name' => 'John Kiprotich',
            'parent_phone' => '+254 712 998 877',
            'total_fee_due_kes' => 45000,
            'total_fee_paid_kes' => 45000,
            'fee_balance_kes' => 0,
            'status' => 'Active',
        ]);

        // 6. Seed Property Listing
        PropertyListing::create([
            'organization_id' => $org->id,
            'property_code' => 'PROP-RH',
            'name' => 'Riverside Heights Apartments',
            'location' => 'Riverside Drive, Nairobi',
            'total_units' => 24,
            'occupied_units' => 22,
            'monthly_rent_kes' => 52000,
            'status' => 'Active',
        ]);
    }
}
