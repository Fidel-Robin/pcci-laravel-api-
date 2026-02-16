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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('membership_type_id')->constrained()->cascadeOnDelete();
            $table->string('or_number')->unique();
            $table->decimal('amount', 10, 2);
            $table->foreignId('received_by_user_id')->constrained('users')->cascadeOnDelete();
            $table->date('payment_date');
            $table->timestamps();

             // ✅ Prevent duplicate payment per applicant
            $table->unique('applicant_id');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
