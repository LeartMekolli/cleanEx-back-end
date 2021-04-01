<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestmessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requestmessages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned(); //user_id - clienti
            $table->bigInteger('post_id')->unsigned();
            $table->string('message');
            $table->string('title',150);
            $table->tinyInteger('status');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requestmessages');
    }
}
