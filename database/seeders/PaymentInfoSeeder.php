<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('thongtinthanhtoan')->insertOrIgnore([
            [
                'id' => 3,
                'pttt_id' => 2,
                'ten_nganhang' => 'MB',
                'so_taikhoan' => '0866468126',
                'ten_chutaikhoan' => 'NGUYEN DUC TUAN',
                'chi_nhanh' => 'Bắc Giang',
                'noi_dung_mau' => 'FOODSHOP',
                'ma_nganhang' => 'MB',
            ],
        ]);
    }
}
