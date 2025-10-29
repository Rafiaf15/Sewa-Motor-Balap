<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Motor;
use Illuminate\Support\Str;

$motors = Motor::whereNull('unit_code')->orWhere('unit_code', '')->get();

if ($motors->isEmpty()) {
    echo "No motors need unit_code generation.\n";
    exit(0);
}

foreach ($motors as $motor) {
    // create a readable code based on name + random suffix
    $base = Str::upper(Str::slug($motor->name, ''));
    $suffix = strtoupper(Str::random(4));
    $code = substr($base, 0, 6) . '-' . $suffix;

    // ensure uniqueness
    while (Motor::where('unit_code', $code)->exists()) {
        $suffix = strtoupper(Str::random(4));
        $code = substr($base, 0, 6) . '-' . $suffix;
    }

    $motor->unit_code = $code;
    $motor->save();

    echo "Set unit_code for motor ID {$motor->id} ({$motor->name}) => {$code}\n";
}

echo "Done.\n";
