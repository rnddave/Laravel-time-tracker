<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TimeCodeController extends Controller
{
    /**
     * Display a listing of the time codes.
     */
    public function index()
    {
        $timeCodes = TimeCode::paginate(10);
        return view('admin.timecodes.index', compact('timeCodes'));
    }

    /**
     * Show the form for creating a new time code.
     */
    public function create()
    {
        return view('admin.timecodes.create');
    }

    /**
     * Store a newly created time code in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'code' => 'required|string|max:50|unique:time_codes,code',
            'description' => 'required|string|max:255',
        ]);

        // Create time code
        $timeCode = TimeCode::create([
            'code' => $request->code,
            'description' => $request->description,
        ]);

        Log::info("Time Code created: ID {$timeCode->id} ({$timeCode->code}) by Admin ID " . auth()->id());

        return redirect()->route('admin.timecodes.index')->with('success', 'Time Code created successfully.');
    }

    /**
     * Display the specified time code.
     */
    public function show($id)
    {
        $timeCode = TimeCode::findOrFail($id);
        return view('admin.timecodes.show', compact('timeCode'));
    }

    /**
     * Show the form for editing the specified time code.
     */
    public function edit($id)
    {
        $timeCode = TimeCode::findOrFail($id);
        return view('admin.timecodes.edit', compact('timeCode'));
    }

    /**
     * Update the specified time code in storage.
     */
    public function update(Request $request, $id)
    {
        $timeCode = TimeCode::findOrFail($id);

        // Validate input
        $request->validate([
            'code' => 'required|string|max:50|unique:time_codes,code,' . $timeCode->id,
            'description' => 'required|string|max:255',
        ]);

        // Update time code
        $timeCode->update([
            'code' => $request->code,
            'description' => $request->description,
        ]);

        Log::info("Time Code updated: ID {$timeCode->id} ({$timeCode->code}) by Admin ID " . auth()->id());

        return redirect()->route('admin.timecodes.index')->with('success', 'Time Code updated successfully.');
    }

    /**
     * Remove the specified time code from storage.
     */
    public function destroy($id)
    {
        $timeCode = TimeCode::findOrFail($id);

        // Check if time code is used in any timesheets
        if ($timeCode->timesheets()->count() > 0) {
            return redirect()->route('admin.timecodes.index')->withErrors(['error' => 'Cannot delete time code used in timesheets.']);
        }

        $timeCode->delete();

        Log::info("Time Code deleted: ID {$timeCode->id} ({$timeCode->code}) by Admin ID " . auth()->id());

        return redirect()->route('admin.timecodes.index')->with('success', 'Time Code deleted successfully.');
    }
}
