<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'user_id' => rand(1,10),
        'service_id' => rand(1,5),
        'location' => City::where('id',rand(1,37))->first()->city_name .','.City::where('id',rand(1,37))->first()->city_name.','.City::where('id',rand(1,37))->first()->city_name,
        'title' => $this->faker->text($maxNbChars = 20) ,
        'content' => $this->faker->text($maxNbChars = 30) ,
        'price' => rand(10,500),
        'payment_status' => 1,
        'active' => 1,
        'created_at' => now(),
        'updated_at' => now(),
        ];
    }
}
