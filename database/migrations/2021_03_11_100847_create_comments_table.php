<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('service_id')->unsigned();
            $table->string('comment'); //komenti
           /// $table->dateTime('comment_date')->default(DB::raw('NOW()')); //data e komentimit
            $table->string('rating'); //prej 1 deri ne 10
            $table->timestamps();//created_at and updated_at
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
