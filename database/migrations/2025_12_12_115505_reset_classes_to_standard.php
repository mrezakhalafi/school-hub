<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Clear existing classes
        DB::table('classes')->truncate();

        // Insert the 6 standard classes
        DB::table('classes')->insert([
            ['name' => '10 IPA', 'level' => '10', 'major' => 'IPA'],
            ['name' => '10 IPS', 'level' => '10', 'major' => 'IPS'],
            ['name' => '11 IPA', 'level' => '11', 'major' => 'IPA'],
            ['name' => '11 IPS', 'level' => '11', 'major' => 'IPS'],
            ['name' => '12 IPA', 'level' => '12', 'major' => 'IPA'],
            ['name' => '12 IPS', 'level' => '12', 'major' => 'IPS'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // For rollback, clear the classes again
        DB::table('classes')->truncate();
    }
};
