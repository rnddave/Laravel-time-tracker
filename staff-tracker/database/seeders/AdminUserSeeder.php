<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Timesheet Admin',
            'email' => 'timesheet-admin-master@onemoredavid.com',
            'password' => 'Password123',
            'role' => 'admin',
            'password_changed_at' => now(),
        ]);
    }
}
