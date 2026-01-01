<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('phuongthucthanhtoan')->insertOrIgnore([
            [
                'id' => 1,
                'ten_pttt' => 'Chuyển khoản ngân hàng',
                'trangthai' => 1,
                'mota' => '',
            ],
            [
                'id' => 2,
                'ten_pttt' => 'Tiền mặt khi nhận hàng (COD)',
                'trangthai' => 1,
                'mota' => '',
            ],
        ]);
    }
}
