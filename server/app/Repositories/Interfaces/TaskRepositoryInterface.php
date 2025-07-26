<?php

namespace App\Repositories\Interfaces;

interface TaskRepositoryInterface
{
    public function allForUser(int $userId);
    public function findForUser(int $id, int $userId);
    public function create(array $data);
    public function update(array $data, int $id, int $userId);
    public function delete(int $id, int $userId);
}