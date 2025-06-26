<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('project_images', 'public');
        }

        // Create project with description and image path
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'invite_code' => Str::random(8),
        ]);

        // Attach the current user as project manager
        $project->users()->attach(auth()->id(), ['role' => 'manager']);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function joinForm()
    {
        return view('projects.join');
    }

    public function join(Request $request)
    {
        $request->validate(['invite_code' => 'required']);

        $project = Project::where('invite_code', $request->invite_code)->first();

        if (!$project) {
            return back()->withErrors(['invite_code' => 'Invalid invite code']);
        }

        if ($project->users->contains(auth()->id())) {
            return redirect()->route('projects.index')->with('info', 'You already joined this project.');
        }

        $project->users()->attach(auth()->id(), ['role' => 'member']);

        return redirect()->route('projects.index')->with('success', 'Joined project successfully.');
    }
}
