<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'housing_type', 'num_units',
        'location', 'delivery_date', 'price', 'surface_area', 'description',
        'bedrooms', 'bathrooms', 'rent_or_buy', 'payment_plan', 'project_timeline',
        'additional_housing_types', 'f1_count', 'f2_count', 'f3_count', 'f4_count'
    ];

    protected $casts = [
        'payment_plan' => 'array',
        'project_timeline' => 'array',
        'additional_housing_types' => 'array',
        'f1_count' => 'integer',
        'f2_count' => 'integer',
        'f3_count' => 'integer',
        'f4_count' => 'integer',
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
