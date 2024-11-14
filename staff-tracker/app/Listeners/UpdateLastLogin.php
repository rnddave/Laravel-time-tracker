<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LogEntry; // Ensure this import exists

class UpdateLastLogin
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // Update the last login timestamp
        $event->user->last_login_at = now();
        $event->user->save();

        // Log the login event
        LogEntry::create([
            'message' => "User ID {$event->user->id} ({$event->user->name}) logged in.",
        ]);
    }
}
