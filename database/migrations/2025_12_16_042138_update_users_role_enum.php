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
        // Temporarily set the column to allow the new values
        Schema::table('users', function (Blueprint $table) {
            $table->string('temp_role')->default('student');
        });

        // Copy the old values to the temp column
        \DB::statement('UPDATE users SET temp_role = role');

        // Drop the old column and create the new one with extended values
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'teacher', 'student', 'security_guard', 'office_boy'])->default('student');
        });

        // Copy the data back
        \DB::statement('UPDATE users SET role = temp_role');

        // Drop the temporary column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('temp_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only revert non-extended roles for backward compatibility
        \DB::statement("UPDATE users SET role = 'student' WHERE role IN ('security_guard', 'office_boy')");

        Schema::table('users', function (Blueprint $table) {
            $table->string('temp_role')->default('student');
        });

        \DB::statement('UPDATE users SET temp_role = role');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'teacher', 'student'])->default('student');
        });

        \DB::statement('UPDATE users SET role = temp_role');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('temp_role');
        });
    }
};
