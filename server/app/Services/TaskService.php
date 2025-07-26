<?php

namespace App\Services;

use App\Repositories\Interfaces\{
    TaskRepositoryInterface,
    UserRepositoryInterface
};
use App\Events\TaskCreated;

class TaskService
{
    public function __construct(
        protected TaskRepositoryInterface $taskRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function getUserTasks(int $userId)
    {
        return $this->taskRepository->allForUser($userId);
    }

    public function getUserTask(int $id, int $userId)
    {
        return $this->taskRepository->findForUser($id, $userId);
    }

    public function createTask(array $data, int $userId)
    {
        $data['user_id'] = $userId;
        $task = $this->taskRepository->create($data);
        
        event(new TaskCreated($task));
        
        return $task;
    }

    public function updateTask(array $data, int $id, int $userId): bool
    {
        return $this->taskRepository->update($data, $id, $userId);
    }

    public function deleteTask(int $id, int $userId): bool
    {
        return $this->taskRepository->delete($id, $userId);
    }
}