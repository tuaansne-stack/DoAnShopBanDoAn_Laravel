<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('thongtinthanhtoan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pttt_id')->constrained('phuongthucthanhtoan')->onDelete('cascade');
            $table->string('ten_nganhang', 100)->nullable();
            $table->string('so_taikhoan', 50)->nullable();
            $table->string('ten_chutaikhoan', 100)->nullable();
            $table->string('chi_nhanh', 100)->nullable();
            $table->string('noi_dung_mau', 255)->nullable();
            $table->string('ma_nganhang', 10)->nullable()->comment('Mã ngân hàng cho VietQR (VCB, TCB, etc)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thongtinthanhtoan');
    }
};

