<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'name', 'email', 'message'];

    // 🔁 Relationship
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
