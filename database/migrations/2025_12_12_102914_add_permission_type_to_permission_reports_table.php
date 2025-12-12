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
        Schema::table('permission_reports', function (Blueprint $table) {
            $table->enum('permission_type', ['sick', 'event', 'family', 'other'])->default('other')->after('permission_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permission_reports', function (Blueprint $table) {
            $table->dropColumn('permission_type');
        });
    }
};
