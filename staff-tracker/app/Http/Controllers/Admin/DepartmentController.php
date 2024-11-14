<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments.
     */
    public function index()
    {
        $departments = Department::with('manager')->paginate(10);
        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        $managers = User::where('role', 'manager')->where('is_active', true)->get();
        return view('admin.departments.create', compact('managers'));
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        // Create department
        $department = Department::create([
            'name' => $request->name,
            'manager_id' => $request->manager_id,
        ]);

        Log::info("Department created: ID {$department->id} ({$department->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified department.
     */
    public function show($id)
    {
        $department = Department::with('manager', 'teams.manager')->findOrFail($id);
        return view('admin.departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified department.
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $managers = User::where('role', 'manager')->where('is_active', true)->get();
        return view('admin.departments.edit', compact('department', 'managers'));
    }

    /**
     * Update the specified department in storage.
     */
    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'manager_id' => 'nullable|exists:users,id',
        ]);

        // Update department
        $department->update([
            'name' => $request->name,
            'manager_id' => $request->manager_id,
        ]);

        Log::info("Department updated: ID {$department->id} ({$department->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
    }

    public function getTeams($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $teams = $department->teams()->select('id', 'name')->get();

        return response()->json(['teams' => $teams]);
    }

    /**
     * Remove the specified department from storage.
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);

        // Check if department has teams
        if ($department->teams()->count() > 0) {
            return redirect()->route('admin.departments.index')->withErrors(['error' => 'Cannot delete department with existing teams.']);
        }

        $department->delete();

        Log::info("Department deleted: ID {$department->id} ({$department->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }
}
