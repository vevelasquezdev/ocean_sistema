<?php

namespace Database\Factories;

use App\Models\admin\Carta;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Carta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tip_pro' => strtoupper($this->faker->streetName),
            'des_pro' => strtoupper($this->faker->streetName),
            'pre_pro'   => 10.59,
        ];
    }
}
