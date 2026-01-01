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
        Schema::create('phuongthucvanchuyen', function (Blueprint $table) {
            $table->id();
            $table->string('ten_ptvc', 100);
            $table->decimal('gia_vanchuyen', 10, 2)->default(0.00);
            $table->boolean('trangthai')->default(true)->comment('Trạng thái phương thức vận chuyển: 1-Hoạt động, 0-Tạm khóa');
            $table->text('mota')->nullable()->comment('Mô tả chi tiết về phương thức vận chuyển');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phuongthucvanchuyen');
    }
};

