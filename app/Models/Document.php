<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'attachable_id',
        'attachable_type',
        'filename',
        'path',
        'type',
    ];

    // === Relationships ===
    public function attachable()
    {
        return $this->morphTo();
    }
}
