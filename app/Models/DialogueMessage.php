<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DialogueMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'activity_id',
        'user_id',
        'content',
        'parent_id',
    ];

    /**
     * A mensagem pertence a um projeto.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * A mensagem pertence a uma atividade.
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
    

    /**
     * A mensagem foi enviada por um usuário (Comunidade, Coordenador, etc.).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Esta mensagem é uma resposta a outra mensagem (parent).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(DialogueMessage::class, 'parent_id');
    }

    /**
     * Esta mensagem tem respostas (replies).
     */
    public function replies(): HasMany
    {
        return $this->hasMany(DialogueMessage::class, 'parent_id');
    }
}
