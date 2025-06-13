<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'housing_type', 'num_units',
        'location', 'delivery_date', 'price', 'surface_area', 'description'
    ];

    // 🔁 Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }
}
