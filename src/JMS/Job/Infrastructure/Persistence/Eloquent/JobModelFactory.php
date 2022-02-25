<?php

declare(strict_types=1);

namespace JMS\Job\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Factories\Factory;

final class JobModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'title' => $this->faker->randomElement(
                [
                    'Job A',
                    'Job B',
                    'Job C',
                    'Job D'
                ]
            ),
            'description' => $this->faker->randomElement(
                [
                    'Job description A',
                    'Job description B',
                    'Job description C',
                    'Job description D'
                ]
            ),
            'user_id' => $this->faker->uuid,
        ];
    }
}
