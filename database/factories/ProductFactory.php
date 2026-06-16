<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $locations = ['Pahawang', 'Krui', 'Teluk Kiluan'];
        $name      = fake()->sentence(3);

        return [
            'user_id'           => User::factory()->vendor(),
            'category_id'       => Category::factory(),
            'name'              => $name,
            'slug'              => Str::slug($name) . '-' . Str::random(5),
            'description'       => fake()->paragraphs(3, true),
            'short_description' => fake()->sentence(10),
            'price'             => fake()->randomElement([150000, 250000, 350000, 500000, 750000, 1200000]),
            'price_unit'        => fake()->randomElement(['malam', 'jam', 'set', 'trip']),
            'location'          => fake()->randomElement($locations),
            'address'           => fake()->address(),
            'latitude'          => fake()->latitude(-5.8, -5.2),
            'longitude'         => fake()->longitude(104.5, 105.3),
            'thumbnail'         => null,
            'gallery'           => null,
            'capacity'          => fake()->numberBetween(2, 20),
            'facilities'        => fake()->randomElements(
                ['WiFi', 'AC', 'Kamar Mandi Dalam', 'Parkir', 'Sarapan', 'Life Jacket', 'Guide', 'P3K'],
                fake()->numberBetween(2, 5)
            ),
            'whatsapp'          => '08' . fake()->numerify('##########'),
            'rating'            => 0,
            'total_reviews'     => 0,
            'is_featured'       => fake()->boolean(30),
            'is_active'         => true,
            'sort_order'        => 0,
        ];
    }

    /** Mark as featured. */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
