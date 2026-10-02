<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_schedule_id')->nullable()->constrained('visit_schedules')->nullOnDelete();
            $table->foreignId('resident_id')->constrained('residents')->cascadeOnDelete();
            $table->foreignId('bhw_user_id')->constrained('users')->cascadeOnDelete();
            
            // Health Vitals & Findings
            $table->string('vitals_bp')->nullable(); // e.g., 120/80
            $table->decimal('vitals_weight_kg', 5, 2)->nullable();
            $table->decimal('vitals_temp_c', 4, 1)->nullable();
            $table->string('vitals_blood_sugar')->nullable();
            $table->text('health_notes')->nullable();
            $table->text('services_rendered')->nullable();
            
            // Follow-up requirement
            $table->boolean('follow_up_needed')->default(false);
            $table->date('follow_up_date')->nullable();
            $table->text('follow_up_reason')->nullable();
            
            // Geolocation tracking details (Specific Objective 4)
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('accuracy_meters', 8, 2)->nullable(); // Reported accuracy in meters
            $table->boolean('geo_permission_granted')->default(true);
            $table->boolean('geo_verified')->default(true); // Verified against household bounds
            $table->timestamp('captured_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_logs');
    }
};
