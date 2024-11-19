<?php

namespace Database\Factories\Currency;

use App\Models\Currency\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    protected $model = Currency::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->randomElement(['USD', 'EUR', 'GBP', 'JPY', 'AUD']),
            'name' => $this->faker->word,
        ];
    }
}
