<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model {
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'required_slots', 
        'status',
    ];

    // === Relationships ===
    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function registrations() {
        return $this->hasMany(Registration::class);
    }

    public function feedbacks() {
        return $this->hasMany(Feedback::class);
    }

    public function documents() {
        return $this->morphMany(Document::class, 'attachable');
    }
}
