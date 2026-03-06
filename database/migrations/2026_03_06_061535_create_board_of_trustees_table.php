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
        Schema::create('board_of_trustees', function (Blueprint $table) {

            $table->id();

            $table->string('image')->nullable();

            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename')->nullable();

            $table->enum('gender', ['male', 'female']);

            $table->foreignId('board_position_id')
                ->constrained('board_positions')
                ->cascadeOnDelete();

            $table->enum('status', ['active', 'inactive'])
                ->default('active');
                

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_of_trustees');
    }
};
