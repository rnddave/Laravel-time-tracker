<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    // Timesheet dashboard

    public function index() 
    {
        return view('timesheets.index');
    }
}
