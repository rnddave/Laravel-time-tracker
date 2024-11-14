<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the users with search and filter options.
     */
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin')->with(['department', 'team']);

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->input('status') === 'active' ? true : false;
            $query->where('is_active', $status);
        }

        $users = $query->paginate(10)->appends($request->all());

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $departments = Department::all();
        $teams = Team::all(); // Alternatively, you can filter teams based on selected department via AJAX

        return view('admin.users.create', compact('departments', 'teams'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:8|confirmed',
            'role'          => 'required|in:team_member,manager,admin',
            'department_id' => 'required|exists:departments,id',
            'team_id'       => 'required|exists:teams,id',
            'is_active'     => 'sometimes|boolean',
        ]);

        // Additional validation to ensure team belongs to department
        $department = Department::findOrFail($request->department_id);
        if (!$department->teams->contains('id', $request->team_id)) {
            return back()->withErrors(['team_id' => 'Selected team does not belong to the chosen department.'])->withInput();
        }

        // Create the user
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => $request->role,
            'department_id' => $request->department_id,
            'team_id'       => $request->team_id,
            'is_active'     => $request->boolean('is_active'),
        ]);

        // Log the creation (optional)
        Log::info("User created: User ID {$user->id} ({$user->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }


    /**
     * Display the specified user's details.
     */
    public function show($id)
    {
        $user = User::with(['manager', 'department', 'team'])->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $departments = Department::all();
        $teams = $user->department ? $user->department->teams()->select('id', 'name')->get() : collect();

        return view('admin.users.edit', compact('user', 'departments', 'teams'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the request
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password'      => 'nullable|string|min:8|confirmed',
            'role'          => 'required|in:team_member,manager,admin',
            'department_id' => 'required|exists:departments,id',
            'team_id'       => 'required|exists:teams,id',
            'is_active'     => 'sometimes|boolean',
        ]);

        // Additional validation to ensure team belongs to department
        $department = Department::findOrFail($request->department_id);
        if (!$department->teams->contains('id', $request->team_id)) {
            return back()->withErrors(['team_id' => 'Selected team does not belong to the chosen department.'])->withInput();
        }

        // Update user details
        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->role          = $request->role;
        $user->department_id = $request->department_id;
        $user->team_id       = $request->team_id;
        $user->is_active     = $request->boolean('is_active');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Log the update (optional)
        Log::info("User updated: User ID {$user->id} ({$user->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }


    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Log the deletion
        Log::info("User deleted: User ID {$user->id} ({$user->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Search users (optional, already handled in index).
     */
    public function search(Request $request)
    {
        // Optional: Since search is handled in index, this can be removed or kept for separate search pages.
    }
}
