<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $teams = auth()->user()->teams;
        return view('teams.index', compact('teams'));
    }

    public function create(){
        return view('teams.create');
    }

    public function store(Request $request){
        $request->validate(['name' => 'require|string|max:255']);

        $team = Team::create([
            'name' => $request->name,
            'invite_code' => Str::random(8),
        ]);

        $team->users()->attach(auth()->id(), ['role' => 'admin']);

        return redirect()->route('teams.index')->with('success', 'Team created successfully.');
    }

    public function joinForm(){
        return view('teams.join');
    }

    public function join(Request $request){
        $request->validate(['invite_code' => 'required']);
        $team = Team::where('invite_code', $request->invite_code)->first();
        if(!$team) {
            return back()->withErrors(['invite_code' => 'Invalid invite code.']);
        }

        if($team->users()->contains(auth()->id())) {
            return redirect()->route('teams.index')->with('info', 'You are already a member of this team.');
        }

        $team->users()->attach(auth()->id(), ['role' => 'member']);

        return redirect()->route('teams.index')->with('success', 'Joined team successfully.');
    }
}
