<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $types = ['income','expense'];

        $type = array_rand($types);

        $happened_on = Carbon::parse($this->faker->dateTimeBetween('-1 months', '+1 months'));

        return [
            'title' => $this->faker->word(),
            'type' => $types[$type],
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'amount' => rand(1000, 5000),
            'happened_on' => $happened_on
        ];
    }
}
