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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "10 IPA 1", "11 IPS 2"
            $table->string('level'); // e.g., "10", "11", "12"
            $table->string('major'); // e.g., "IPA", "IPS"
            $table->string('section')->nullable(); // e.g., "1", "2", "A", "B"
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('set null')->onUpdate('cascade'); // Class advisor
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
