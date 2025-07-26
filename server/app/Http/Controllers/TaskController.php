<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) 
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request): JsonResponse
    {
        $tasks = $this->taskService->getUserTasks($request->user()->id);
        return response()->json($tasks);
    }

    public function show(Request $request, $id): JsonResponse
    {
        $task = $this->taskService->getUserTask($id, $request->user()->id);
        return $task
            ? response()->json($task)
            : response()->json(['error' => 'Task not found'], 404);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTask($request->validated(), $request->user()->id);
        return response()->json($task, 201);
    }

    public function update(TaskRequest $request, $id): JsonResponse
    {
        $success = $this->taskService->updateTask(
            $request->validated(), 
            $id, 
            $request->user()->id
        );
        
        return $success
            ? response()->json(['message' => 'Task updated'])
            : response()->json(['error' => 'Task not found'], 404);
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        $success = $this->taskService->deleteTask($id, $request->user()->id);
        
        return $success
            ? response()->json(['message' => 'Task deleted'])
            : response()->json(['error' => 'Task not found'], 404);
    }
}