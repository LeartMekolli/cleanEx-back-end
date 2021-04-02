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

        $array_cities = file_get_contents(base_path('app\resources\qytetet_kosoves.json'));

        $json_cities = json_decode($array_cities, true);
        

        $check_item = \App\Models\Country::where('country_name','Kosova')->first();
        if($check_item == null){
            \App\Models\Country::create(['country_name'=>'Kosova']);
        }
        $get_country_id = \App\Models\Country::where('country_name','Kosova')->first()->id;

        foreach($json_cities as $cities_items){

            foreach($cities_items as $city => $regions) {
                $check_item = \App\Models\City::where('city_name',$city)->first();
                if($check_item == null){
                    \App\Models\City::create(['city_name'=>$city,'country_id'=>$get_country_id]);
                }
                $get_city_id = \App\Models\City::where('city_name',$city)->first()->id;
                foreach($regions as $region){
                    $check_item = \App\Models\Region::where('id',$region)->first();
                    if($check_item == null){
                        \App\Models\Region::create(['region_name'=>$region,'city_id'=>$get_city_id]);
                }
                }
           }
        }



        $json_job_string = file_get_contents(base_path('app\resources\jobs.json'));

        $job_data = json_decode($json_job_string, true);

        foreach($job_data as $item){
            $check_item = \App\Models\Service::where('name',$item['name'])->first();
            if($check_item == null){
                \App\Models\Service::create(['name'=>$item['name']]);
            }
            
            
        }
        \App\Models\Gender::create(['gender_type'=>'Mashkull']);
        \App\Models\Gender::create(['gender_type'=>'Femër']);
        \App\Models\Gender::create(['gender_type'=>'Tjetër']);



    }
}
