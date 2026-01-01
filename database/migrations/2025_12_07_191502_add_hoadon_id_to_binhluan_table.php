<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHoadonIdToBinhluanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('binhluan', function (Blueprint $table) {
            $table->unsignedBigInteger('hoadon_id')->nullable()->after('user_id');
            $table->foreign('hoadon_id')->references('id')->on('hoadon')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('binhluan', function (Blueprint $table) {
            $table->dropForeign(['hoadon_id']);
            $table->dropColumn('hoadon_id');
        });
    }
}
