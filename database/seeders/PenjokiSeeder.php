<?php

namespace Database\Seeders;

use App\Models\Joki;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PenjokiSeeder extends Seeder
{
    public function run()
    {
        $jokis = [
            [
                'name' => 'Alex Marquez',
                'category' => 'expert',
                'bio' => 'Joki professional dengan pengalaman 10 tahun di sirkuit internasional',
                'price_per_day' => 1000000,
                'available' => true,
                'photo' => 'jokis/alex.jpg'
            ],
            [
                'name' => 'Dani Pedrosa',
                'category' => 'menengah',
                'bio' => 'Joki berpengalaman 5 tahun di berbagai sirkuit nasional',
                'price_per_day' => 750000,
                'available' => true,
                'photo' => 'jokis/dani.jpg'
            ],
            [
                'name' => 'Marc Marquez',
                'category' => 'pemula',
                'bio' => 'Joki muda berbakat dengan pengalaman 2 tahun di sirkuit lokal',
                'price_per_day' => 500000,
                'available' => true,
                'photo' => 'jokis/marc.jpg'
            ],
        ];

        foreach ($jokis as $joki) {
            Joki::create([
                'name' => $joki['name'],
                'slug' => Str::slug($joki['name']),
                'category' => $joki['category'],
                'bio' => $joki['bio'],
                'price_per_hour' => $joki['price_per_hour'],
                'available' => $joki['available'],
                'photo' => $joki['photo']
            ]);
        }
    }
}