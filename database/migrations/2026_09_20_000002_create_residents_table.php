<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('household_id')->constrained('households')->cascadeOnDelete();
            $table->string('family_code')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->date('date_of_birth');
            $table->string('sex'); // Male, Female
            $table->string('civil_status')->default('Single');
            $table->string('contact_number')->nullable();
            $table->string('philhealth_number')->nullable();
            $table->boolean('is_head')->default(false);
            
            // Vulnerability & Health Profile Indicators
            $table->boolean('is_pregnant')->default(false);
            $table->boolean('is_lactating')->default(false);
            $table->boolean('is_infant')->default(false); // 0-12 months
            $table->boolean('is_senior')->default(false); // 60+
            $table->boolean('is_pwd')->default(false);
            $table->boolean('has_hypertension')->default(false);
            $table->boolean('has_diabetes')->default(false);
            $table->boolean('has_malnutrition')->default(false);
            $table->string('immunization_status')->nullable(); // Fully Immunized, Incomplete, N/A
            $table->text('medical_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
