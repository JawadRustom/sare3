<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'image' => $this->faker->word(),
            'regular_price' => $this->faker->randomFloat(0, 0, 9999999999.),
            'sale_price' => $this->faker->randomFloat(0, 0, 9999999999.),
            'brand_id' => Brand::factory(),
        ];
    }
}
