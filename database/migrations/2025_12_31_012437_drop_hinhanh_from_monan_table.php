<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropHinhanhFromMonanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monan', function (Blueprint $table) {
            $table->dropColumn('hinhanh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monan', function (Blueprint $table) {
            $table->string('hinhanh')->nullable()->after('mota');
        });
    }
}
