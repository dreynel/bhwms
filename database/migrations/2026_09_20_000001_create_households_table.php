<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('households', function (Blueprint $table) {
            $table->id();
            $table->string('household_number')->unique();
            $table->string('head_name');
            $table->string('purok');
            $table->string('barangay')->default('Poblacion');
            $table->string('municipality')->default('New Lucena');
            $table->string('province')->default('Iloilo');
            $table->text('address_details')->nullable();
            $table->string('water_source')->default('Level II - Communal Faucet');
            $table->string('sanitary_toilet')->default('Water-sealed Sanitary Toilet');
            $table->string('income_bracket')->default('Low-Income / NTHP');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('households');
    }
};
