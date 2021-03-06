<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creator_id');
            $table->string('title');
            $table->string('description');
            $table->string('location');
            $table->string('hash_tag');
            $table->dateTime('event_date');
            $table->string('event_pic');
            $table->string('phone');
            $table->integer('status')->default(0); // 0 모집 , 1 종료 , 2 취소
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
        Schema::dropIfExists('events');
    }
}
