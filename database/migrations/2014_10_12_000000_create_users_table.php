<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('provider');
            $table->string('provider_id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('gender');
            $table->string('age');
            $table->string('area1');
            $table->string('area2');
            $table->string('pic');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
