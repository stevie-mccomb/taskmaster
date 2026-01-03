<?php

namespace App\Models;

use App\Rules\ProjectBelongingToUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    /**
     * The attributes that are mass-assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'task_status_id',
        'user_id',
        'title',
        'content',
        'priority',
    ];

    /**
     * Return the project that this task belongs to.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Return the status of this task.
     */
    public function taskStatus(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }

    /**
     * Return the 
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Sort the returned collection by the `priority` column.
     */
    public function scopePrioritized(Builder $query): Builder
    {
        return $query->orderBy('priority');
    }

    /**
     * Return the validation rules for upserting tasks.
     */
    public function validationRules(): array
    {
        return [
            'project_id' => [ 'required', 'integer', new ProjectBelongingToUser, ],
            'task_status_id' => 'required|integer|exists:task_statuses,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'priority' => 'required|integer|min:0',
        ];
    }
}
