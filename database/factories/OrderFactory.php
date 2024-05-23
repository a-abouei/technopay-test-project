<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            Order::CUSTOMER_ID => random_int(1, 10000),
            Order::STATUS => $this->faker->randomElement([
                OrderStatus::INIT->value,
                OrderStatus::IN_PROGRESS->value,
                OrderStatus::FAILED->value,
                OrderStatus::SUCCEED->value,
            ]),
            Order::AMOUNT => random_int(10000, 100000000),
        ];
    }
}
