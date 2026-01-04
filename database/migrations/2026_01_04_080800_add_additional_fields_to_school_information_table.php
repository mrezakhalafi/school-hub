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
        Schema::table('school_information', function (Blueprint $table) {
            $table->string('accreditation')->nullable();
            $table->integer('founding_year')->nullable();
            $table->integer('student_capacity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_information', function (Blueprint $table) {
            $table->dropColumn(['accreditation', 'founding_year', 'student_capacity']);
        });
    }
};
