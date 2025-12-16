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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade'); // Belongs to a class
            $table->string('day'); // Monday, Tuesday, Wednesday, Thursday, Friday
            $table->integer('hour'); // 7 to 14 (representing hours 7 AM to 2 PM)
            $table->string('subject')->nullable(); // Subject name
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('set null'); // Assigned teacher
            $table->timestamps();

            // Ensure unique combination of class, day, and hour
            $table->unique(['class_id', 'day', 'hour']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
