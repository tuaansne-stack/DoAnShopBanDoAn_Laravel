<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonanToppingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monan_topping', function (Blueprint $table) {
            $table->unsignedBigInteger('monan_id');
            $table->unsignedBigInteger('topping_id');
            $table->primary(['monan_id', 'topping_id']);
            $table->foreign('monan_id')->references('id')->on('monan')->onDelete('cascade');
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
        Schema::dropIfExists('monan_topping');
    }
}
