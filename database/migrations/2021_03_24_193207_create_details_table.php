<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('region_id')->unsigned();
            $table->bigInteger('gender_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthday'); 
            $table->binary('image')->nullable();  
            $table->string('phone_number');
            $table->string('street_name',200);
            $table->string('street_number')->nullable();
            $table->string('postal_code',5)->nullable();
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
        Schema::dropIfExists('details');
    }
}
