<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TimeCodeController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\Admin\TimesheetController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ManagerStaffController;
use App\Http\Controllers\Admin\AdminManagementController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Password Change Routes
|--------------------------------------------------------------------------
*/

// Accessible to authenticated and verified users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/password/change', [PasswordChangeController::class, 'showChangeForm'])->name('password.change');
    Route::post('/password/change', [PasswordChangeController::class, 'changePassword'])->name('password.change.post');
});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'password.changed'])->group(function () {
    // Dashboard accessible by all authenticated users
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // User Management
        Route::resource('users', UserController::class);
        // Search for users
        Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

        // Admins Management
        Route::resource('admins', AdminManagementController::class);
        // Toggle Admin Status
        Route::patch('/admins/{admin}/toggle', [AdminManagementController::class, 'toggleStatus'])->name('admins.toggle');

        // Departments Management
        Route::get('/departments/{department}/teams', [DepartmentController::class, 'getTeams'])->name('departments.teams');

        Route::resource('departments', DepartmentController::class);
        // Teams Management
        Route::resource('teams', TeamController::class);
        // Time Codes Management
        Route::resource('timecodes', TimeCodeController::class);
        // Timesheets Management
        Route::resource('timesheets', TimesheetController::class);

        // Staff-Manager relationships
        Route::resource('managers', ManagerStaffController::class)->only(['index', 'edit', 'update', 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | Manager Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkRole:manager'])->prefix('manager')->name('manager.')->group(function () {
        // Manager Dashboard
        Route::get('/dashboard', [ManagerController::class, 'index'])->name('dashboard');
        // ... other manager routes
    });

    /*
    |--------------------------------------------------------------------------
    | Team Member Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkRole:team_member'])->prefix('timesheets')->name('timesheets.')->group(function () {
        // Timesheets Index
        Route::get('/', [TimesheetController::class, 'index'])->name('index');
        // ... other timesheet routes
    });
});
