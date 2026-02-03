<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();

            // === FOR PCCI USE ONLY (Upper Right) ===
            $table->date('date_submitted')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->date('date_approved')->nullable();
            $table->string('membership_type')->nullable();

            // === PHOTO ===
            $table->string('photo')->nullable();

            // === BASIC PROFILE ===
            $table->string('registered_business_name');
            $table->string('trade_name')->nullable();

            // Address Breakdown
            $table->string('business_address');
            $table->string('city_municipality');
            $table->string('province');
            $table->string('region');
            $table->string('zip_code', 10);

            $table->string('telephone_no', 25);
            $table->string('website_socmed')->nullable();
            $table->date('member_dob');
            $table->string('email')->unique();
            $table->string('tin_no')->nullable();

            // === OFFICIAL REPRESENTATIVE TO PCCI ===
            $table->string('rep_first_name');
            $table->string('rep_mid_name')->nullable();
            $table->string('rep_surname');
            $table->string('rep_designation');
            $table->date('rep_dob');
            $table->string('rep_contact_no', 25);

            // === ALTERNATE REPRESENTATIVE ===
            $table->string('alt_first_name');
            $table->string('alt_mid_name')->nullable();
            $table->string('alt_surname');
            $table->string('alt_designation');
            $table->date('alt_dob');
            $table->string('alt_contact_no', 25);

            // === MEMBERSHIP IN OTHER BUSINESS ORGANIZATION ===
            $table->string('name_of_organization', 500)->nullable();

            // === REGISTRATION & COMPANY DETAILS ===
            $table->string('registration_number');
            $table->date('date_of_registration');
            $table->enum('type_of_company', [
                'Corporation',
                'Partnership',
                'Single Proprietorship'
            ]);
            $table->unsignedInteger('number_of_employees');
            $table->year('year_established');

            // === FOR PCCI-VALENZUELA CITY USE ONLY ===
            $table->string('recommending_approval')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
