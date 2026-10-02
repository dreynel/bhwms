<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangay_settings', function (Blueprint $table) {
            $table->id();
            $table->string('barangay_name')->default('Poblacion');
            $table->string('municipality')->default('New Lucena');
            $table->string('province')->default('Iloilo');
            $table->string('captain_name')->default('Hon. Jose R. Maravilla');
            $table->string('health_officer_name')->default('Dr. Maria Santos, MD');
            $table->string('contact_phone')->default('(033) 540-1234');
            $table->string('office_address')->default('Barangay Health Station, Poblacion, New Lucena, Iloilo');
            $table->json('purok_list')->nullable(); // Purok 1 to Purok 7, etc.
            $table->text('system_announcement')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangay_settings');
    }
};
