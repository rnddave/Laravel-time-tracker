<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TeamController extends Controller
{
    /**
     * Display a listing of the teams.
     */
    public function index()
    {
        $teams = Team::with(['department', 'manager'])->paginate(10);
        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new team.
     */
    public function create()
    {
        $departments = Department::all();
        $managers = User::where('role', 'manager')->where('is_active', true)->get();
        return view('admin.teams.create', compact('departments', 'managers'));
    }

    /**
     * Store a newly created team in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
            'department_id' => 'required|exists:departments,id',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        // Create team
        $team = Team::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'manager_id' => $request->manager_id,
        ]);

        Log::info("Team created: ID {$team->id} ({$team->name}) in Department ID {$team->department_id} by Admin ID " . auth()->id());

        return redirect()->route('admin.teams.index')->with('success', 'Team created successfully.');
    }

    /**
     * Display the specified team.
     */
    public function show($id)
    {
        $team = Team::with(['department', 'manager', 'users'])->findOrFail($id);
        return view('admin.teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified team.
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);
        $departments = Department::all();
        $managers = User::where('role', 'manager')->where('is_active', true)->get();
        return view('admin.teams.edit', compact('team', 'departments', 'managers'));
    }

    /**
     * Update the specified team in storage.
     */
    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
            'department_id' => 'required|exists:departments,id',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        // Update team
        $team->update([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'manager_id' => $request->manager_id,
        ]);

        Log::info("Team updated: ID {$team->id} ({$team->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.teams.index')->with('success', 'Team updated successfully.');
    }

    /**
     * Remove the specified team from storage.
     */
    public function destroy($id)
    {
        $team = Team::findOrFail($id);

        // Check if team has users
        if ($team->users()->count() > 0) {
            return redirect()->route('admin.teams.index')->withErrors(['error' => 'Cannot delete team with existing members.']);
        }

        $team->delete();

        Log::info("Team deleted: ID {$team->id} ({$team->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.teams.index')->with('success', 'Team deleted successfully.');
    }
}
