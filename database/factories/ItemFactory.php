<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use \Bezhanov\Faker\ProviderCollectionHelper;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = fake();
        ProviderCollectionHelper::addAllProvidersTo($faker);

        $nameParts = [
            $faker->medicine,
            $faker->randomElement(range(10, 800, 10)),
            $faker->randomElement(['mg', 'ml'])
        ];

        $name = implode(' ', $nameParts);
        return [
            'name' => $name,
            'sku' => Str::upper('MZ-' . substr($name, 0, 1). $faker->ean8()),
            'price' => $faker->numberBetween(10, 1000),
        ];
    }
}
