<?php

namespace Database\Factories;

use App\Models\SalesAgents;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesAgentsFactory extends Factory
{
    protected $model = SalesAgents::class;

    public function definition()
    {
        return [
            'user_id' => Users::factory(),
            'job_position' => $this->faker->jobTitle,
            'image' => $this->faker->imageUrl,
        ];
    }
}

