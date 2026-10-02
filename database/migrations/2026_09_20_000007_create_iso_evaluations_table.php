<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iso_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('evaluator_name');
            $table->enum('evaluator_role', ['bhw', 'supervisor', 'it_expert', 'resident']);
            $table->string('organization')->default('Barangay Poblacion Health Center');
            
            // ISO/IEC 25010:2011 8 Characteristics Scores (1 to 5 scale)
            $table->decimal('score_functional_suitability', 3, 2);
            $table->decimal('score_performance_efficiency', 3, 2);
            $table->decimal('score_compatibility', 3, 2);
            $table->decimal('score_usability', 3, 2);
            $table->decimal('score_reliability', 3, 2);
            $table->decimal('score_security', 3, 2);
            $table->decimal('score_maintainability', 3, 2);
            $table->decimal('score_portability', 3, 2);
            
            $table->decimal('overall_mean', 3, 2);
            $table->string('verbal_interpretation'); // e.g. "Excellent", "Very Good"
            $table->text('feedback_comments')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iso_evaluations');
    }
};
