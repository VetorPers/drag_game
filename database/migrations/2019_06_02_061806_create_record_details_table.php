<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('record_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('question_id');
            $table->string('answer_ids');
            $table->unsignedTinyInteger('is_right')->default(0);
            $table->unsignedInteger('score')->default(0);
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
        Schema::dropIfExists('record_details');
    }
}
