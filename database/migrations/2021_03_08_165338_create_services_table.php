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
            $table->dateTime('created_at')->default(DB::raw('NOW()')); 
            $table->string('status')->default(DB::raw('false')); 
            $table->string('deleted')->default(DB::raw('false')); 
            //$table->json('service_area');
            
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
