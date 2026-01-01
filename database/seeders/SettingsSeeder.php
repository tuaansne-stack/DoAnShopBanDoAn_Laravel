<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::firstOrCreate(
            ['id' => 1],
            [
                'logo' => 'logo.png',
                'favicon' => 'panther_icon.ico',
                'shop_info' => 'Panther Shop',
                'website_info' => 'Food Shop - Chuyên cung cấp đồ ăn ngon, chất lượng',
                'hotline' => '0866 468 126',
                'email' => 'julyasiin@gmail.com',
                'address' => 'Đại Học Bách Khoa Hà Nội',
                'facebook' => 'https://facebook.com',
                'twitter' => 'https://twitter.com',
                'instagram' => 'https://instagram.com',
                'zalo' => '0866468126',
                'pinterest' => 'https://pinterest.com',
                'linkedin' => 'https://linkedin.com',
                'tiktok' => 'https://tiktok.com',
            ]
        );
    }
}

