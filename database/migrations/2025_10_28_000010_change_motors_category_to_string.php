<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change enum category to VARCHAR so we can support new categories/variants
        DB::statement("ALTER TABLE motors MODIFY category VARCHAR(255) NOT NULL DEFAULT 'pemula'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum (may fail if values outside original set exist)
        DB::statement("ALTER TABLE motors MODIFY category ENUM('pemula','menengah','expert') NOT NULL DEFAULT 'pemula'");
    }
};
