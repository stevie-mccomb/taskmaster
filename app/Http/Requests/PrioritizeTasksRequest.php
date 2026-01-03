<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class PrioritizeTasksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $taskIds = collect($this->all())->map(fn ($item) => array_keys($item)[0]);
        $tasks = Task::whereIn('tasks.id', $taskIds)->where('tasks.user_id', $this->user()->id)->get();
        foreach ($tasks as $task) {
            if ($task->user_id !== $this->user()->id) {
                return false;
            }
        }
        return true;
    }
}
