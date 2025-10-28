<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    /**
     * O nome da tabela.
     *
     * @var string
     */
    protected $table = 'enrollments';

    /**
     * Os atributos que podem ser preenchidos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'activity_id',
        'status', // pending, approved, rejected
        'enrolled_at',
    ];

    /**
     * Relacionamento: Uma inscrição pertence a um utilizador.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento: Uma inscrição pertence a uma atividade.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
