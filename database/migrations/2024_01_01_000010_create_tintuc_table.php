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
        Schema::create('tintuc', function (Blueprint $table) {
            $table->id();
            $table->string('tieude', 200);
            $table->text('noidung');
            $table->text('tomtat')->nullable();
            $table->string('hinhanh', 255)->nullable();
            $table->dateTime('ngaydang')->useCurrent();
            $table->dateTime('ngaycapnhat')->useCurrent()->useCurrentOnUpdate();
            $table->string('tacgia', 100)->nullable();
            $table->integer('luotxem')->default(0);
            $table->enum('trangthai', ['Công khai', 'Bản nháp', 'Ẩn'])->default('Công khai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tintuc');
    }
};

