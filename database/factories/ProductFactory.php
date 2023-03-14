<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category_ids = DB::table('categories')->pluck('id')->toArray();

        return [
            'title' => $this->faker->realText(50),
            'amount' => $this->faker->randomDigitNotZero(),
            'price' => $this->faker->randomFloat(2, 0.01, 1000),
            'discount' => $this->faker->numberBetween(0, 100),
            'description' => $this->faker->realText(),
            'image' => 'Image.png',
            'category_id' => $this->faker->randomElement($category_ids),
            'user_id' => $this->faker->randomElement([1, 2]),
        ];
    }
}
