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
                'description' => 'Joki professional dengan pengalaman 10 tahun di sirkuit internasional',
                'price_per_day' => 1000000,
                'available' => true,
                'image' => 'build/assets/image/Jokis/Alex.jpg'
            ],
            [
                'name' => 'Dani Pedrosa',
                'category' => 'menengah',
                'description' => 'Joki berpengalaman 5 tahun di berbagai sirkuit nasional',
                'price_per_day' => 750000,
                'available' => true,
                'image' => 'build/assets/image/Jokis/Dani.jpg'
            ],
            [
                'name' => 'Marc Marquez',
                'category' => 'pemula',
                'description' => 'Joki muda berbakat dengan pengalaman 2 tahun di sirkuit lokal',
                'price_per_day' => 500000,
                'available' => true,
                'image' => 'build/assets/image/Jokis/marc.jpg'
            ],
            [
                'name' => 'Am Rayong',
                'category' => 'expert',
                'description' => 'Joki muda berbakat dengan pengalaman 5 tahun di balap drag',
                'price_per_day' => 550000,
                'available' => true,
                'image' => 'build/assets/image/Jokis/rayong.jpg'
            ],
        ];

        // Hapus data yang ada terlebih dahulu
        Joki::truncate();

        foreach ($jokis as $joki) {
            $slug = Str::slug($joki['name']);
            Joki::create([
                'name' => $joki['name'],
                'slug' => $slug,
                'category' => $joki['category'],
                'description' => $joki['description'],
                'price_per_day' => $joki['price_per_day'],
                'available' => $joki['available'],
                'image' => $joki['image']
            ]);
        }
    }
}