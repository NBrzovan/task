<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{

    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    
    public function definition()
    {
        return [
            'task_name' => $this->faker->sentence,
            'priority' => $this->faker->numberBetween(1, 10),
            'project_id' => $this->faker->randomNumber(1, 5),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
