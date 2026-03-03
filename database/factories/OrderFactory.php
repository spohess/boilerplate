<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Order\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'customer_name' => fake()->name(),
            'customer_email' => fake()->unique()->safeEmail(),
            'product' => fake()->word(),
            'quantity' => fake()->numberBetween(1, 10),
            'total_price' => fake()->numberBetween(1000, 100000),
            'status' => 'pending',
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'confirmed',
            'amount' => fake()->uuid(),
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'failed',
        ]);
    }
}
