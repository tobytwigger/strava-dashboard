<?php

namespace Database\Factories;

use App\Models\ClubSyncronisation;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClubSyncronisationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClubSyncronisation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'team_id' => fn () => Team::factory(),
            'record_count' => $this->faker->numberBetween(0, 1000)
        ];
    }
}
