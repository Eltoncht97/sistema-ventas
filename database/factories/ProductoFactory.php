<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Producto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "codigo" => $this->faker->numberBetween(1000, 9999),
            "nombre" => $this->faker->name(),
            "descripcion" => $this->faker->text(),
            "precio" => $this->faker->randomNumber(2),
            "url_imagen" => $this->faker->imageUrl(200, 100),
            "likes" => rand(0, 10),
            "dislikes" => rand(0, 10)
        ];
    }
}
