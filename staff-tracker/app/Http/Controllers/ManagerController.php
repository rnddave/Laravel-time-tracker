<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    // Manager dashboard

    public function index() {
        return view('manager.dashboard');
    }
}
