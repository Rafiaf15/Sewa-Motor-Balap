<?php

namespace Database\Seeders;

use App\Models\Motor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MotorSeeder extends Seeder
{
    public function run()
    {
        $motors = [
            // Motor Balap
            [
                'name' => 'Honda CBR250RR',
                'category' => 'balap',
                'description' => 'Motor balap performa tinggi untuk sirkuit',
                'price_per_day' => 500000,
                'available' => true,
                'image' => 'build/assets/image/Motors/CBR250CC.png'
            ],
            [
                'name' => 'Yamaha R6',
                'category' => 'balap',
                'description' => 'Motor balap profesional untuk penggemar kecepatan',
                'price_per_day' => 450000,
                'available' => true,
                'image' => 'build/assets/image/Motors/YamahaR6.jpg'
            ],
            [
                'name' => 'Kawasaki ZX-6R',
                'category' => 'balap',
                'description' => 'Motor balap andal untuk track days dan latihan',
                'price_per_day' => 480000,
                'available' => true,
                'image' => 'build/assets/image/Motors/KawasakiZX6R.jpg'
            ],
            [
                'name' => 'Kawasaki Ninja 250',
                'category' => 'balap',
                'description' => 'Motor balap pemula untuk track days dan latihan',
                'price_per_day' => 280000,
                'available' => true,
                'image' => 'build/assets/image/Motors/Ninja250.png'
            ],
            // Motor Normal - varian matic, sport, bebek
            [   
                'name' => 'Honda Vario 125',
                'category' => 'normal-matic',
                'description' => 'Motor matic irit dan nyaman untuk harian',
                'price_per_day' => 120000,
                'available' => true,
                'image' => 'build/assets/image/Motors/Vario.jpg'
            ],
            [
                'name' => 'Yamaha Vixion',
                'category' => 'normal-sport',
                'description' => 'Motor sport harian yang lincah dan responsif',
                'price_per_day' => 150000,
                'available' => true,
                'image' => 'build/assets/image/Motors/Vixion.png'
            ],
            [
                'name' => 'Honda Revo',
                'category' => 'normal-bebek',
                'description' => 'Motor bebek hemat bahan bakar untuk mobilitas sehari-hari',
                'price_per_day' => 90000,
                'available' => true,
                'image' => 'build/assets/image/Motors/Revo.jpg'
            ],
            [
                'name' => 'Yamaha R15',
                'category' => 'balap',
                'description' => 'Motor balap kompak dengan performa mengesankan',
                'price_per_day' => 350000,
                'available' => true,
                'image' => 'build/assets/image/Motors/Yamahar15.png'
            ],

        ];

        // Hapus data yang ada terlebih dahulu
        Motor::truncate();
        
        foreach ($motors as $motor) {
            $slug = Str::slug($motor['name']);
            Motor::create(
                [
                    'name' => $motor['name'],
                    'slug' => $slug,
                    'category' => $motor['category'],
                    'description' => $motor['description'],
                    'price_per_day' => $motor['price_per_day'],
                    'available' => $motor['available'],
                    'stock' => 5,
                    'image' => $motor['image']
                ]
            );
        }
    }
}