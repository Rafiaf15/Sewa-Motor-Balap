<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Motor;
use App\Models\Joki;

class MotorAndJokiSeeder extends Seeder
{
    public function run()
    {
        $motors = [
            ['name' => 'RB-100', 'slug' => 'rb-100', 'category' => 'pemula', 'price_per_day' => 150000],
            ['name' => 'RS-200', 'slug' => 'rs-200', 'category' => 'menengah', 'price_per_day' => 250000],
            ['name' => 'RX-500', 'slug' => 'rx-500', 'category' => 'expert', 'price_per_day' => 450000],
        ];

        foreach ($motors as $m) {
            Motor::create(array_merge($m, ['available' => true]));
        }

        $jokis = [
            ['name' => 'Joni Pemula', 'slug' => 'joni-pemula', 'category' => 'pemula', 'price_per_hour' => 50000],
            ['name' => 'Andi Menengah', 'slug' => 'andi-menengah', 'category' => 'menengah', 'price_per_hour' => 100000],
            ['name' => 'Budi Expert', 'slug' => 'budi-expert', 'category' => 'expert', 'price_per_hour' => 200000],
        ];

        foreach ($jokis as $j) {
            Joki::create(array_merge($j, ['available' => true]));
        }
    }
}
