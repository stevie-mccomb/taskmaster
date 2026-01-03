<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    /**
     * The attributes that are mass-assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'slug',
    ];

    /**
     * Return the key to use for route binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Return the user that owns this project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return the tasks that belong to this project.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Return projects sorted alphabetically by name.
     */
    public function scopeAlphabetized(Builder $query): Builder
    {
        return $query->orderBy('name');
    }
}
