<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvidencePhoto extends Model
{
    protected $fillable = ['evidence_id', 'filename', 'disk'];

    protected $appends = ['url'];

    public function evidence(): BelongsTo
    {
        return $this->belongsTo(Evidence::class);
    }

    public function getUrlAttribute(): string
    {
        $disk = $this->disk ?? 'public';
        $filename = $this->filename;

        try {
            if (Storage::disk($disk)->exists($filename)) {
                return Storage::disk($disk)->url($filename);
            }
            // Tentar sem prefixo
            $cleanFilename = str_replace('public/', '', $filename);
            if (Storage::disk($disk)->exists($cleanFilename)) {
                return Storage::disk($disk)->url($cleanFilename);
            }
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar URL da foto: ' . $filename);
        }

        return '';
    }
}
