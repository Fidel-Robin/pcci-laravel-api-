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
            $table->date('date_submitted')->nullable();;
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->date('date_approved')->nullable();
            $table->string('membership_type')->nullable();

            // === PHOTO ===
            $table->string('photo')->nullable(); // Stores the file path

            // === BASIC PROFILE ===
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('surname');
            $table->string('trade_name')->nullable();
            
            // Address Breakdown
            $table->string('business_house_number')->nullable();
            $table->string('business_street')->nullable();
            $table->string('business_subdivision')->nullable();
            $table->string('business_barangay');
            $table->string('city_municipality');
            $table->string('province');
            $table->string('region');
            $table->string('zip_code');
            
            $table->string('telephone_no');
            $table->string('website')->nullable();
            $table->date('dob');
            $table->string('email')->unique();
            $table->string('tin_no');

            // === OFFICIAL REPRESENTATIVE ===
            $table->string('rep_title')->nullable();
            $table->string('rep_first_name');
            $table->string('rep_mi', 10)->nullable();
            $table->string('rep_surname');
            $table->string('rep_designation');
            $table->date('rep_dob');
            $table->string('rep_contact_no');
            $table->string('rep_signature_path')->nullable();

            // === ALTERNATE REPRESENTATIVE ===
            $table->string('alt_rep_title')->nullable();
            $table->string('alt_first_name');
            $table->string('alt_mi', 10)->nullable();
            $table->string('alt_surname');
            $table->string('alt_designation');
            $table->date('alt_dob');
            $table->string('alt_contact_no');
            $table->string('alt_signature_path')->nullable();

            // === OTHER ORGANIZATIONS ===
            $table->text('other_organizations')->nullable();

            // === FORM OF ORGANIZATION & SIZE ===
            $table->string('form_of_organization');
            $table->string('registration_type'); // SEC or DTI
            $table->string('registration_number');
            $table->date('date_of_registration');
            $table->string('type_of_company');
            $table->integer('number_of_employees');
            $table->year('year_established');

            // === BUSINESS LINE ===
            $table->text('business_line');

            // === FOR PCCI-VALENZUELA CITY USE ONLY ===
            $table->string('referred_by')->nullable();
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