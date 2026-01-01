<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('phuongthucvanchuyen')->insertOrIgnore([
            [
                'id' => 1,
                'ten_ptvc' => 'Giao hàng tiết kiệm',
                'gia_vanchuyen' => 20000.00,
                'trangthai' => 1,
                'mota' => '',
            ],
            [
                'id' => 2,
                'ten_ptvc' => 'Giao hàng nhanh',
                'gia_vanchuyen' => 40000.00,
                'trangthai' => 1,
                'mota' => '',
            ],
            [
                'id' => 3,
                'ten_ptvc' => 'Khách Hàng Đến Lấy',
                'gia_vanchuyen' => 0.00,
                'trangthai' => 1,
                'mota' => '',
            ],
        ]);
    }
}
