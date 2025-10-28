<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;


class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // === Relationships ===
    public function projects() {
        return $this->hasMany(Project::class, 'coordinator_id');
    }

    public function coordinatedProjects() {
        return $this->hasMany(Project::class);
    }
    public function activities() {
        return $this->hasMany(Activity::class);
    }
    public function enrollments() {
        return $this->hasMany(Enrollment::class);
    }

    public function registrations() {
        return $this->hasMany(Registration::class);
    }

    public function announcements() {
        return $this->hasMany(Announcement::class);
    }

    public function dialogueMessages() {
        return $this->hasMany(DialogueMessage::class);
    }

    public function feedbacks() {
        return $this->hasMany(Feedback::class);
    }
    public function initials(): string {
        // Divide o nome em partes (ex.: "João da Silva")
        $parts = explode(' ', $this->name);

        // Pega a primeira letra do primeiro e último nome
        $first = strtoupper(substr($parts[0] ?? '', 0, 1));
        $last = strtoupper(substr(end($parts) ?: '', 0, 1));

        return $first . $last;
    }
}
