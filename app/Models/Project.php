<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'coordinator_id',
        'start_date',
        'end_date',
        'status',
         'objectives',
        'expected_results',
        'target_audience',
        'area_of_activity',
    ];

    // === Relationships ===
    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'attachable');
    }
}
