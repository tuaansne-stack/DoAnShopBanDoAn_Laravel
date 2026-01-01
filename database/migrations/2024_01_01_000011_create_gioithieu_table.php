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
        Schema::create('gioithieu', function (Blueprint $table) {
            $table->id();
            $table->string('tieude', 200);
            $table->text('noidung');
            $table->string('hinhanh', 255)->nullable();
            $table->integer('thutu')->default(0);
            $table->enum('trangthai', ['Hiện', 'Ẩn'])->default('Hiện');
            $table->dateTime('ngaytao')->useCurrent();
            $table->dateTime('ngaycapnhat')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gioithieu');
    }
};

