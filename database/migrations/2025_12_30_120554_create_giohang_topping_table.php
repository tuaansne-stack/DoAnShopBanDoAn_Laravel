<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiohangToppingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giohang_topping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('giohang_id');
            $table->unsignedBigInteger('topping_id');
            $table->integer('soluong')->default(1);
            $table->foreign('giohang_id')->references('id')->on('giohang')->onDelete('cascade');
            $table->foreign('topping_id')->references('id')->on('topping')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('giohang_topping');
    }
}
