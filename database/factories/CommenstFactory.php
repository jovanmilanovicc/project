<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
class CommenstFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_id'=>rand(0,50),
            'author'=>$this->faker->userName(),
            'body'=>$this->faker->text(20),
        ];
    }
}
