<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'user_id',
        'status', // 'pending', 'approved', 'rejected', 'attended'
        'enrollment_date',
    ];

    protected $casts = [
        'enrollment_date' => 'datetime',
    ];

    // Por boa prática, a tabela deveria chamar-se 'registrations'
    // protected $table = 'registrations';

    // === Relationships ===

    // Relação com a Atividade
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    // Relação com o Utilizador
    public function user()
    {
        // Assumimos que o modelo de Utilizador é App\Models\User
        return $this->belongsTo(User::class);
    }
}
    