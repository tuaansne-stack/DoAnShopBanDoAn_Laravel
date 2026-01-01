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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monan_id')->constrained('monan')->onDelete('cascade');
            $table->string('hinhanh', 255);
            $table->boolean('is_main')->default(false)->comment('1 = Hình ảnh chính hiển thị thumbnail');
            $table->integer('sort_order')->default(0)->comment('Thứ tự sắp xếp hình ảnh');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
