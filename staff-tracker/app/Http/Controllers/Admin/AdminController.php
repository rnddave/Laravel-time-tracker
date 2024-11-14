<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function toggleStatus($id)
    {
        $admin = User::findOrFail($id);

        $admin->is_active = !$admin->is_active;
        $admin->save();

        if ($admin->is_active) {
            Log::info("Admin activated: User ID {$admin->id} ({$admin->name}) by Admin ID " . Auth::id());
            return redirect()->route('admin.admins.index')->with('success', 'Admin activated successfully.');
        } else {
            Log::info("Admin deactivated: User ID {$admin->id} ({$admin->name}) by Admin ID " . Auth::id());
            return redirect()->route('admin.admins.index')->with('success', 'Admin deactivated successfully.');
        }
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
