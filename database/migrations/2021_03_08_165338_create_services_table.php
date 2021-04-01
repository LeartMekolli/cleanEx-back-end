<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned(); //user_id - mjeshtri
            $table->bigInteger('job_id')->unsigned();
            $table->bigInteger('payment_id')->unsigned()->nullable(); //ne momentin qe bene payment servisi i behet visible
            $table->string('job_description');
            $table->double('price', 15, 8); 
            $table->tinyInteger('status');  // 1 is true , 0 is false
            $table->tinyInteger('deleted')->default(DB::raw(0));  // 1 is true , 0 is false
            //$table->json('service_area');
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
        Schema::dropIfExists('services');
    }
}
