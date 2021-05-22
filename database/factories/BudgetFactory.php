<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Budget;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Budget::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start_date = Carbon::parse($this->faker->dateTimeBetween('-1 months', '+1 months'));

        $end_date = (clone $start_date)->addDays(random_int(0, 14));

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'amount' => rand(1000, 5000),
            'start_date' => $start_date,
            'end_date' => $end_date
        ];
    }
}
