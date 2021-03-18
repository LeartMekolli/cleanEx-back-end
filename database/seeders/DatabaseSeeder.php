<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();


        // create job list here
        $jsonString = file_get_contents(base_path('app\resources\Qytetet_e_Kosoves_Database.json'));

        $data = json_decode($jsonString, true);

        foreach($data as $item){
            $checkItem = \App\Models\City::where('city',$item['city'])->first();
            
            if($checkItem == null){
                \App\Models\City::create(['city'=>$item['city']]);
            }
            
            
        }

        $jsonJobString = file_get_contents(base_path('app\resources\jobs.json'));

        $job_data = json_decode($jsonJobString, true);

        foreach($job_data as $item){
            $checkItem = \App\Models\Job::where('name',$item['name'])->first();
            if($checkItem == null){
                \App\Models\Job::create(['name'=>$item['name']]);
            }
            
            
        }


    }
}
