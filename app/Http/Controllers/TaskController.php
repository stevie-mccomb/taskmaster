<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\DestroyTaskRequest;
use App\Http\Requests\PrioritizeTasksRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaskController extends Controller
{
    /**
     * Create a new task in storage for the given project.
     */
    public function asyncStore(CreateTaskRequest $request, Project $project): JsonResponse
    {
        $data = $request->safe()->toArray();
        $data['project_id'] = $project->id;
        $data['user_id'] = $request->user()->id;

        $task = $project->tasks()->create($data);

        return response()->json($task);
    }

    /**
     * Update the given task in storage for the given project.
     */
    public function asyncUpdate(UpdateTaskRequest $request, Project $project, Task $task): JsonResponse
    {
        $data = $request->safe()->toArray();
        $data['project_id'] = $project->id;
        $data['user_id'] = $request->user()->id;

        $task->update($data);

        return response()->json($task->fresh());
    }

    /**
     * Update the `priority` value for all tasks in the given status stack.
     */
    public function asyncPrioritize(PrioritizeTasksRequest $request, Project $project): JsonResponse
    {
        $tasks = collect();

        foreach ($request->all() as $transaction) {
            $taskId = array_keys($transaction)[0];
            $priority = array_values($transaction)[0];
            $task = Task::find($taskId);
            $task->update([ 'priority' => $priority ]);
            $tasks->push($task);
        }

        return response()->json($tasks);
    }

    /**
     * Delete the given task from storage.
     */
    public function asyncDestroy(DestroyTaskRequest $request, Project $project, Task $task): JsonResponse
    {
        $task->delete();

        return response()->json();
    }
}
