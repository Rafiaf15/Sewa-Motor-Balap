<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('motors', function (Blueprint $table) {
            if (!Schema::hasColumn('motors', 'unit_code')) {
                $table->string('unit_code')->nullable()->unique()->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('motors', function (Blueprint $table) {
            if (Schema::hasColumn('motors', 'unit_code')) {
                $table->dropUnique(['unit_code']);
                $table->dropColumn('unit_code');
            }
        });
    }
};
