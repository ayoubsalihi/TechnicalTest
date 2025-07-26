<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function allForUser(int $userId)
    {
        return Task::where('user_id', $userId)->get();
    }

    public function findForUser(int $id, int $userId)
    {
        return Task::where('user_id', $userId)->find($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(array $data, int $id, int $userId): bool
    {
        $task = Task::where('user_id', $userId)->find($id);
        return $task ? $task->update($data) : false;
    }

    public function delete(int $id, int $userId): bool
    {
        $task = Task::where('user_id', $userId)->find($id);
        return $task ? $task->delete() : false;
    }
}