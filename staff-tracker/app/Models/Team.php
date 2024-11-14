<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'department_id', 'manager_id'];

    /**
     * Get the department that owns the team.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the manager of the team.
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get the users assigned to the team.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
