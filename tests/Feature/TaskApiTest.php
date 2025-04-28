<?php
namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_tasks()
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/tasks');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data')
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'title', 'description', 'completed', 'created_at', 'updated_at']
                     ],
                     'message'
                 ]);
    }

    public function test_can_create_task()
    {
        $taskData = [
            'title' => 'New Test Task',
            'description' => 'This is a test task',
            'completed' => false
        ];

        $response = $this->postJson('/api/v1/tasks', $taskData);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'title' => $taskData['title'],
                     'description' => $taskData['description'],
                     'completed' => $taskData['completed']
                 ]);
                 
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function test_cannot_create_task_without_title()
    {
        $taskData = [
            'description' => 'This is a test task',
            'completed' => false
        ];

        $response = $this->postJson('/api/v1/tasks', $taskData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title']);
    }

    public function test_can_get_single_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/v1/tasks/{$task->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $task->id,
                     'title' => $task->title
                 ]);
    }

    public function test_will_fail_with_invalid_task_id()
    {
        $response = $this->getJson('/api/v1/tasks/999');

        $response->assertStatus(404);
    }

    public function test_can_update_task()
    {
        $task = Task::factory()->create();
        
        $updatedData = [
            'title' => 'Updated Task Title',
            'completed' => true
        ];

        $response = $this->putJson("/api/v1/tasks/{$task->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment($updatedData);
                 
        $this->assertDatabaseHas('tasks', array_merge(
            ['id' => $task->id],
            $updatedData
        ));
    }

    public function test_can_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/v1/tasks/{$task->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}

// tests/Unit/TaskRepositoryTest.php
namespace Tests\Unit;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskRepositoryTest extends TestCase
{
    use RefreshDatabase;
    
    protected $taskRepository;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->taskRepository = new TaskRepository(new Task());
    }
    
    public function test_can_get_all_tasks()
    {
        Task::factory()->count(3)->create();
        
        $tasks = $this->taskRepository->getAll();
        
        $this->assertCount(3, $tasks);
    }
    
    public function test_can_create_task()
    {
        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'completed' => false
        ];
        
        $task = $this->taskRepository->create($taskData);
        
        $this->assertEquals($taskData['title'], $task->title);
        $this->assertEquals($taskData['description'], $task->description);
        $this->assertEquals($taskData['completed'], $task->completed);
    }
    
    public function test_can_find_task_by_id()
    {
        $createdTask = Task::factory()->create();
        
        $foundTask = $this->taskRepository->getById($createdTask->id);
        
        $this->assertEquals($createdTask->id, $foundTask->id);
    }
    
    public function test_will_throw_exception_for_invalid_id()
    {
        $this->expectException(ModelNotFoundException::class);
        
        $this->taskRepository->getById(999);
    }
    
    public function test_can_update_task()
    {
        $task = Task::factory()->create();
        
        $updatedData = [
            'title' => 'Updated Title',
            'completed' => true
        ];
        
        $updatedTask = $this->taskRepository->update($task->id, $updatedData);
        
        $this->assertEquals($updatedData['title'], $updatedTask->title);
        $this->assertEquals($updatedData['completed'], $updatedTask->completed);
    }
    
    public function test_can_delete_task()
    {
        $task = Task::factory()->create();
        
        $this->taskRepository->delete($task->id);
        
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}