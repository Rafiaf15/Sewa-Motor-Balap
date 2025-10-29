<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ktp_photo')->nullable()->after('remember_token');
            $table->string('simc_photo')->nullable()->after('ktp_photo');
            $table->timestamp('kyc_verified_at')->nullable()->after('simc_photo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['ktp_photo', 'simc_photo', 'kyc_verified_at']);
        });
    }
};


