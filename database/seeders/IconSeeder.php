<?php

namespace Database\Seeders;

use App\Models\Icons;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultIcons = [
            'material-symbols:devices-other-rounded',
            'fluent:food-16-filled',
            'fluent:gas-pump-20-filled',
            'clarity:coin-bag-solid',
            'mdi:internet',
            'mdi:dog',
            'ph:house-bold',
            'mdi:fire-alert'
        ];
        
        foreach($defaultIcons as $icon){
            Icons::query()->insert([
                'iconify_name' => $icon,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
