<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jokis', function (Blueprint $table) {
            // Add new columns alongside the old ones to avoid renameColumn dependency
            $table->text('description')->nullable()->after('category');
            $table->decimal('price_per_day', 10, 2)->default(0)->after('description');
            $table->string('image')->nullable()->after('available');
        });

        // Backfill new columns from old data
        DB::statement('UPDATE jokis SET description = COALESCE(description, bio)');
        DB::statement('UPDATE jokis SET price_per_day = COALESCE(price_per_day, price_per_hour)');
        DB::statement('UPDATE jokis SET image = COALESCE(image, photo)');

        // Drop old columns
        Schema::table('jokis', function (Blueprint $table) {
            $table->dropColumn(['bio', 'price_per_hour', 'photo']);
        });
    }

    public function down(): void
    {
        // Recreate old columns
        Schema::table('jokis', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('category');
            $table->decimal('price_per_hour', 10, 2)->default(0)->after('bio');
            $table->string('photo')->nullable()->after('available');
        });

        // Backfill old columns from new data
        DB::statement('UPDATE jokis SET bio = COALESCE(bio, description)');
        DB::statement('UPDATE jokis SET price_per_hour = COALESCE(price_per_hour, price_per_day)');
        DB::statement('UPDATE jokis SET photo = COALESCE(photo, image)');

        // Drop new columns
        Schema::table('jokis', function (Blueprint $table) {
            $table->dropColumn(['description', 'price_per_day', 'image']);
        });
    }
};


