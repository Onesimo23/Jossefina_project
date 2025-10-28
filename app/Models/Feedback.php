<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback'; // porque migration chama feedback (não feedbacks)

    protected $fillable = [
        'activity_id',
        'user_id',
        'rating',
        'comment',
    ];

    // === Relationships ===
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
