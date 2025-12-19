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
        Schema::create('health_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->integer('height')->nullable(); // in cm
            $table->decimal('weight', 5, 2)->nullable(); // in kg
            $table->string('blood_pressure')->nullable(); // e.g., 120/80
            $table->string('vision_test_result')->nullable();
            $table->string('hearing_test_result')->nullable();
            $table->string('dental_health')->nullable();
            $table->json('allergies')->nullable(); // store as JSON array
            $table->json('medical_conditions')->nullable(); // store as JSON array
            $table->text('medications')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->json('immunization_records')->nullable(); // store as JSON array
            $table->date('date_checked')->nullable();
            $table->string('checked_by')->nullable(); // name of healthcare provider
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_records');
    }
};
