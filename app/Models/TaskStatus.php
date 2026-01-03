<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskStatus extends Model
{
    /**
     * The attributes that are mass-assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'border_style',
        'color_background',
        'color_border',
        'color_text',
    ];

    /**
     * Return the tasks that are of this status.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
