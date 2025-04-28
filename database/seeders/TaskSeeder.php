<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::factory()->count(5)->create();

        $tasks = [
            [
                'title' => 'Complete API Documentation',
                'description' => 'Write comprehensive documentation for the Task Management API including all endpoints and request/response formats.',
                'completed' => false,
            ],
            [
                'title' => 'Implement Authentication',
                'description' => 'Add JWT authentication to secure the API endpoints.',
                'completed' => false,
            ],
            [
                'title' => 'Write Unit Tests',
                'description' => 'Create comprehensive test suite for the application.',
                'completed' => true,
            ],
            [
                'title' => 'Review Code',
                'description' => 'Perform code review to ensure best practices are followed.',
                'completed' => false,
            ],
            [
                'title' => 'Deploy to Production',
                'description' => 'Deploy the application to the production server.',
                'completed' => false,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}