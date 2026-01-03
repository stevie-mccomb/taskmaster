<?php

namespace App\Rules;

use App\Models\Project;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProjectBelongingToUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isValid = Project::where('projects.user_id', auth()->user()->id)->where('projects.id', $value)->exists();

        if (!$isValid) {
            $fail(':attribute must be a project you own.');
        }
    }
}
