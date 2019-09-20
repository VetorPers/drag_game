<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('img');
            $table->integer('order');
            $table->unsignedTinyInteger('time');
            $table->unsignedTinyInteger('right_num')->default(10);
            $table->unsignedTinyInteger('disturb_num')->default(5);
            $table->unsignedTinyInteger('time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pests');
    }
}
