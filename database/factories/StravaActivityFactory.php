<?php

namespace Database\Factories;

use App\Models\StravaActivity;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class StravaActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StravaActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $movingTime = $this->faker->numberBetween(1, 10000);
        $createdAt = $this->faker->dateTimeBetween('-15 months', 'now');
        return [
            'team_id' => fn () => Team::factory(),
            'name' => join(' ', $this->faker->words(4)),
            'distance' => $this->faker->randomFloat(2, 0.2, 150000),
            'elevation_gain' => $this->faker->randomFloat(2, 0, 500),
            'moving_time' => (int) $movingTime * 0.8,
            'elapsed_time' => (int) $movingTime,
            'type' => $this->faker->randomElement([
                'Run', 'Cycle', 'Walk', 'Swim'
            ]),
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ];
    }
}
