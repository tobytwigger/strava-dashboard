<?php

namespace Database\Factories;

use App\Models\StravaConnectionLog;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class StravaConnectionLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StravaConnectionLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement([
                StravaConnectionLog::ERROR,
                StravaConnectionLog::WARNING,
                StravaConnectionLog::INFO,
                StravaConnectionLog::DEBUG,
                StravaConnectionLog::SUCCESS,
            ]),
            'log' => $this->faker->sentence,
            'team_id' => fn () => Team::factory(),
        ];
    }
}
