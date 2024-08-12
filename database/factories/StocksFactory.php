<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Intelligence>
 */
class StocksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $crypto = $this->faker->randomElement([
            ['name' => 'Bitcoin', 'small_name' => 'BTC'],
            ['name' => 'Ethereum', 'small_name' => 'ETH'],
            ['name' => 'Altcoin', 'small_name' => 'ATL'],
            ['name' => 'BNB', 'small_name' => 'BNB'],
            ['name' => 'Solana', 'small_name' => 'SOL'],
            ['name' => 'XRP', 'small_name' => 'XRP'],
        ]);

        $month = $this->faker->randomElement(['01', '02', '03', '04', '05', '06']);

        $created = now()->year . '-' . $month . '-' . rand(1, 22);

        return [
            'name' =>  $crypto['name'],
            'amount' => mt_rand(1, 10000)   ,
            'small_name' => $crypto['small_name'],
            'description' => $this->faker->sentence(),
            'created_at' => $created
        ];
    }
}
