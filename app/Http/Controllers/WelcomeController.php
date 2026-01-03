<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Redirect the user to the appropriate location based on their project/task status.
     */
    public function welcome(Request $request): RedirectResponse
    {
        // User has no projects, prompt them to create one.
        if (empty($request->user()) || $request->user()->projects()->count() <= 0) {
            return redirect(route('projects.create'));
        }

        // User has not selected any projects, but has one available so make the first available project selected.
        if (empty($request->user()->project_id)) {
            $request->user()->update([ 'project_id' => $request->user()->projects()->alphabetized()->value('id') ]);
        }

        // Redirect to the currently-selected project.
        return redirect(route('projects.show', $request->user()->project));
    }
}
