<?php
namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model
     *
     * @var string
    */
    protected $model=\App\Models\Post::class;
    /**
     *
     * @return array
     */
    public function definition()
    {
        return [

            'title'=> $this->faker->sentence(),
            'photo'=>$this->faker->imageUrl('900'.'300'),
            'body'=>$this->faker->paragraph(),
            'slug'=>$this->faker->slug,
            'user_id'=> rand(1,50),

        ];
    }
}
