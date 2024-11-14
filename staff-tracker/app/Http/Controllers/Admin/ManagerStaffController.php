<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Auth; 

class ManagerStaffController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        $this->middleware(['auth', 'checkRole:admin']);
    }

    /**
     * Display a listing of staff members and their managers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all staff with their managers
        $staffMembers = User::with('manager')->paginate(10);

        // Retrieve all potential managers (admins and managers)
        $managers = User::whereIn('role', ['admin', 'manager'])->get();

        return view('admin.managers.index', compact('staffMembers', 'managers'));
    }

    /**
     * Show the form for editing the specified staff member's manager.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $staff = User::findOrFail($id);

        // Retrieve potential managers (admins and managers), excluding self
        $potentialManagers = User::whereIn('role', ['admin', 'manager'])
                                 ->where('id', '!=', $id)
                                 ->get();

        return view('admin.managers.edit', compact('staff', 'potentialManagers'));
    }

    /**
     * Update the specified staff member's manager in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $staff = User::findOrFail($id);

        // Validate the request
        $request->validate([
            'manager_id' => 'nullable|exists:users,id|not_in:' . $id,
        ]);

        // Prevent assigning a staff member as their own manager
        if ($request->manager_id == $id) {
            return redirect()->back()->withErrors(['manager_id' => 'A user cannot be their own manager.']);
        }

        // Additional check: Prevent circular references
        if ($request->manager_id) {
            $newManager = User::find($request->manager_id);
            if ($newManager->manager_id == $id) {
                return redirect()->back()->withErrors(['manager_id' => 'This assignment would create a circular manager relationship.']);
            }
        }

        // Update the manager
        $staff->manager_id = $request->manager_id;
        $staff->save();

        // Log the assignment
        if ($request->manager_id) {
            Log::info("User ID {$staff->id} ({$staff->name}) was assigned to Manager ID {$request->manager_id} ({$newManager->name}) by Admin ID " . Auth::id());
        } else {
            Log::info("Manager assignment removed for User ID {$staff->id} ({$staff->name}) by Admin ID " . Auth::id());
        }

        return redirect()->route('admin.managers.index')->with('success', 'Manager updated successfully.');
    }

    /**
     * Remove the manager assignment from the specified staff member.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $staff = User::findOrFail($id);

        // Remove the manager assignment
        $staff->manager_id = null;
        $staff->save();

        // Log the removal
        Log::info("Manager assignment removed for User ID {$staff->id} ({$staff->name}) by Admin ID " . Auth::id());

        return redirect()->route('admin.managers.index')->with('success', 'Manager unassigned successfully.');
    }
}
