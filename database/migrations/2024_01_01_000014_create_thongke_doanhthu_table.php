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
        Schema::create('thongke_doanhthu', function (Blueprint $table) {
            $table->id();
            $table->date('ngay')->unique();
            $table->integer('so_donhang')->default(0);
            $table->decimal('doanh_thu', 15, 2)->default(0.00);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thongke_doanhthu');
    }
};

