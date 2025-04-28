<?php

namespace App\services;

use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskService
{
    protected $taskRepository;
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    public function getTask()
    {
        return $this->taskRepository->get();
    }
    public function getOneTask(int $id)
    {
        return $this->taskRepository->getById($id);
    }
    public function createTask(array $data)
    {
        if (!isset($data['completed'])) {
            $data['completed'] = false;
        }
        return $this->taskRepository->create($data);
    }
    public function updateTask(array $data, int $id)
    {
        return $this->taskRepository->update($id, $data);
    }
    public function deleteTask(int $id)
    {
        return $this->taskRepository->delete($id);
    }
}
