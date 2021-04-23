<?php

namespace Database\Factories;

use App\Models\Detail;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Detail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
         'first_name' => $this->faker->firstName,
         'last_name' => $this->faker->lastName,
         'gender_id' => rand(1,3),
         'region_id' => rand(1,1373),
         'birthday' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
         'phone_number' => $this->faker->phoneNumber,
         'street_name' => $this->faker->streetName,
         'street_number' => $this->faker->buildingNumber,
         'postal_code' => rand(10000,99999),
         'created_at' => now(),
         'updated_at' => now(),


        ];
    }
}
