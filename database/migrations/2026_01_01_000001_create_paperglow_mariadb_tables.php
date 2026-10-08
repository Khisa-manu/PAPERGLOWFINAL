<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations on MariaDB.
     */
    public function up(): void
    {
        // 1. Organizations (Multi-tenant root)
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('kra_pin')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->default('Nairobi');
            $table->string('county')->default('Nairobi');
            $table->string('country')->default('Kenya');
            $table->string('currency')->default('KES');
            $table->string('plan')->default('enterprise');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // 2. Users (SSO Authentication)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('organizations')->onDelete('cascade');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('business_owner'); // superadmin, business_owner, manager, cashier, customer
            $table->string('phone')->nullable();
            $table->string('avatar_url')->nullable();
            $table->boolean('active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        // 3. Chama Members
        Schema::create('chama_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade');
            $table->string('membership_number')->unique();
            $table->string('full_name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('national_id')->nullable();
            $table->string('role')->default('Member');
            $table->string('status')->default('active');
            $table->date('date_joined');
            $table->decimal('total_contributions_kes', 12, 2)->default(0.00);
            $table->decimal('current_loan_balance_kes', 12, 2)->default(0.00);
            $table->decimal('welfare_contributions_kes', 12, 2)->default(0.00);
            $table->integer('shares_units')->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 4. Chama Contributions
        Schema::create('chama_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('chama_members')->onDelete('cascade');
            $table->string('month');
            $table->integer('year');
            $table->decimal('amount_kes', 12, 2);
            $table->decimal('welfare_kes', 12, 2)->default(0.00);
            $table->decimal('penalty_kes', 12, 2)->default(0.00);
            $table->decimal('total_paid_kes', 12, 2);
            $table->date('payment_date');
            $table->string('payment_method')->default('mpesa');
            $table->string('transaction_reference')->unique();
            $table->string('recorded_by')->nullable();
            $table->string('status')->default('confirmed');
            $table->timestamps();
        });

        // 5. Clinic Patients & Visits
        Schema::create('clinic_patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade');
            $table->string('patient_number')->unique();
            $table->string('full_name');
            $table->string('phone');
            $table->string('gender')->default('Female');
            $table->integer('age');
            $table->string('id_number')->nullable();
            $table->decimal('outstanding_balance_kes', 12, 2)->default(0.00);
            $table->integer('total_visits')->default(1);
            $table->timestamps();
        });

        Schema::create('clinic_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('clinic_patients')->onDelete('cascade');
            $table->string('visit_number')->unique();
            $table->string('doctor_name')->default('Dr. Brenda Muthoni');
            $table->date('visit_date');
            $table->text('chief_complaint');
            $table->string('systolic_bp')->nullable();
            $table->string('diastolic_bp')->nullable();
            $table->decimal('temperature_c', 4, 1)->nullable();
            $table->text('clinical_diagnosis')->nullable();
            $table->text('treatment_plan')->nullable();
            $table->decimal('total_cost_kes', 10, 2)->default(2000.00);
            $table->string('status')->default('completed');
            $table->timestamps();
        });

        // 6. School Students & Fee Payments
        Schema::create('school_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade');
            $table->string('admission_number')->unique();
            $table->string('full_name');
            $table->string('class_name');
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->decimal('total_fee_due_kes', 12, 2);
            $table->decimal('total_fee_paid_kes', 12, 2)->default(0.00);
            $table->decimal('fee_balance_kes', 12, 2)->default(0.00);
            $table->string('status')->default('Active');
            $table->timestamps();
        });

        Schema::create('school_fee_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('school_students')->onDelete('cascade');
            $table->string('receipt_number')->unique();
            $table->string('term')->default('Term 1');
            $table->decimal('amount_kes', 12, 2);
            $table->string('payment_method')->default('mpesa_paybill');
            $table->string('transaction_reference')->unique();
            $table->date('payment_date');
            $table->string('recorded_by')->default('Bursar');
            $table->timestamps();
        });

        // 7. Property Units
        Schema::create('property_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade');
            $table->string('property_code');
            $table->string('name');
            $table->string('location');
            $table->integer('total_units');
            $table->integer('occupied_units');
            $table->decimal('monthly_rent_kes', 12, 2);
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_listings');
        Schema::dropIfExists('school_fee_payments');
        Schema::dropIfExists('school_students');
        Schema::dropIfExists('clinic_visits');
        Schema::dropIfExists('clinic_patients');
        Schema::dropIfExists('chama_contributions');
        Schema::dropIfExists('chama_members');
        Schema::dropIfExists('users');
        Schema::dropIfExists('organizations');
    }
};
