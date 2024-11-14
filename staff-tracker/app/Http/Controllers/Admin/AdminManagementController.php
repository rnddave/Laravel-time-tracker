<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminManagementController extends Controller
{
    /**
     * Display a listing of the admins.
     */
    public function index()
    {
        $admins = User::where('role', 'admin')->paginate(10);
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created admin in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:8|confirmed',
            'is_active'     => 'boolean',
        ]);

        // Create the admin user
        $admin = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => 'admin',
            'password'  => Hash::make($request->password),
            'is_active' => $request->has('is_active'),
        ]);

        // Log the creation
        Log::info("Admin created: User ID {$admin->id} ({$admin->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully.');
    }

    /**
     * Display the specified admin.
     */
    public function show($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('admin.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        // Validate the request
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'password'      => 'nullable|string|min:8|confirmed',
            'is_active'     => 'boolean',
        ]);

        // Update admin details
        $admin->name      = $request->name;
        $admin->email     = $request->email;
        $admin->is_active = $request->boolean('is_active');

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        // Log the update
        Log::info("Admin updated: User ID {$admin->id} ({$admin->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully.');
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        // Prevent deleting self
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.admins.index')->withErrors(['error' => 'You cannot delete your own account.']);
        }

        $admin->delete();

        // Log the deletion
        Log::info("Admin deleted: User ID {$admin->id} ({$admin->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.admins.index')->with('success', 'Admin deleted successfully.');
    }

    /**
     * Toggle the active status of the specified admin.
     */
    public function toggleStatus($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        // Toggle is_active status
        $admin->is_active = !$admin->is_active;
        $admin->save();

        // Log the status toggle
        Log::info("Admin " . ($admin->is_active ? 'activated' : 'deactivated') . ": User ID {$admin->id} ({$admin->name}) by Admin ID " . auth()->id());

        return redirect()->route('admin.admins.index')->with('success', 'Admin status toggled successfully.');
    }
}
