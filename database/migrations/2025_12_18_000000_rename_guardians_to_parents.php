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
        // Rename the guardians table to parents
        Schema::rename('guardians', 'parents');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename the parents table back to guardians
        Schema::rename('parents', 'guardians');
    }
};