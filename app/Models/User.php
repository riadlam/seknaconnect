<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // 🔁 Relationships
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
