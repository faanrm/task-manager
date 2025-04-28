<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskRepository implements TaskRepositoryInterface
{
    protected $task;
    public function __construct(Task $task)
    {
        $this->task = $task;
    }
    public function get()
    {
        return $this->task->all();
    }
    public function getById(int $id)
    {
        $task = $this->task->find($id);
        if (!$task) {
            throw new ModelNotFoundException("Task with ID : {$id} not found");
        }
        return $task;
    }
    public function create(array $data)
    {
        return $this->task->create($data);
    }
    public function update(int $id, array $data)
    {
        $updatedTask = $this->getById($id);
        $updatedTask->update($data);
        return $updatedTask;
    }
    public function delete(int $id)
    {
        $deletedTask = $this->getById($id);
        return $deletedTask->delete();
    }

}