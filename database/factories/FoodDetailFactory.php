<?php

namespace Database\Factories;

use App\Models\Category;
use FakerRestaurant\Provider\en_US\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FoodDetail>
 */
class FoodDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new Restaurant($faker));
        return [
            'photo' => $this->faker->imageUrl(),
            'name' => $faker->foodName(),
            'description' => $this->faker->realText(75),
            'price' => $this->faker->randomNumber(5),
            'unit' => $this->faker->randomElement(['pax', 'pcs']),
            'category_id' => Category::all()->random()->id,
            'is_favorite' => $this->faker->boolean(),
            'is_recommended' => $this->faker->boolean(),
        ];
    }
}
