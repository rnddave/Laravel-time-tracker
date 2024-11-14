<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeCode extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'description'];

    /**
     * Get the timesheets associated with the time code.
     */
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}
