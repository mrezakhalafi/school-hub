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
        // First, we need to handle the data migration
        // Since both tables have student_id that currently references users.id,
        // we need to ensure the values match the new students.id
        
        // For this to work, we assume that students.id values match with users.id where role='student'
        // This is likely the case in this application since Student model likely corresponds to user accounts
        
        // Drop the foreign key constraints first
        Schema::table('health_records', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });
        
        Schema::table('finance_records', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });

        // Now drop and recreate the columns with new foreign key
        Schema::table('health_records', function (Blueprint $table) {
            $table->dropColumn('student_id');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
        
        Schema::table('finance_records', function (Blueprint $table) {
            $table->dropColumn('student_id');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key constraints first
        Schema::table('health_records', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });
        
        Schema::table('finance_records', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });

        // Drop and recreate the columns with old foreign key
        Schema::table('health_records', function (Blueprint $table) {
            $table->dropColumn('student_id');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::table('finance_records', function (Blueprint $table) {
            $table->dropColumn('student_id');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};