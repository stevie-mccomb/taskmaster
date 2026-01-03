<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{
    /**
     * Display the form for creating a new project.
     */
    public function create(Request $request): Response
    {
        $data['project'] = new Project;

        return Inertia::render('projects/Edit', $data);
    }

    /**
     * Display the given project's task board.
     */
    public function show(Request $request, Project $project): Response
    {
        Gate::authorize('view', $project);

        $data['project'] = $project;
        $data['projects'] = $request->user()->projects()->alphabetized()->get();
        $data['tasks'] = $project->tasks()->prioritized()->get();
        $data['taskStatuses'] = TaskStatus::all();

        return Inertia::render('projects/Show', $data);
    }

    /**
     * Display the form for editing an existing project.
     */
    public function edit(Project $project): Response
    {
        $data['project'] = $project;

        return Inertia::render('projects/Edit', $data);
    }

    /**
     * Create a new project in storage.
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $safe = $request->safe();

        $project = Project::create([
            'user_id' => $request->user()->id,
            ...$safe,
        ]);

        $request->user()->update([ 'project_id' => $project->id ]);

        return redirect(route('home'))->with('success', 'Project successfully created.');
    }
}
