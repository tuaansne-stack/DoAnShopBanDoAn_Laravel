<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveHinhanhFromDanhmucTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('danhmuc', function (Blueprint $table) {
            if (Schema::hasColumn('danhmuc', 'hinhanh')) {
                $table->dropColumn('hinhanh');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('danhmuc', function (Blueprint $table) {
            $table->string('hinhanh')->nullable();
        });
    }
}
