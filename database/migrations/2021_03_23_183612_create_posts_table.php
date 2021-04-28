<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned(); //user_id - mjeshtri
            $table->bigInteger('service_id')->unsigned();
            $table->bigInteger('payment_id')->unsigned()->nullable(); //ne momentin qe bene payment servisi i behet visible
            $table->string('location'); //reagioni ku mundesh me punu
            $table->string('title',150); 
            $table->string('content',500);
            $table->double('price', 10, 2); 
            $table->tinyInteger('payment_status');  // 1 is true , 0 is false
            $table->tinyInteger('active')->default(DB::raw(1));  // 1 is true , 0 is false
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
        Schema::dropIfExists('posts');
    }
}
