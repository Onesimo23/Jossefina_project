<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Project\ManageProjects;
use App\Livewire\Activity\ManageActivities;
use App\Livewire\Public\ActivityList;
use App\Livewire\Enrollment\MyEnrollments;
use App\Livewire\Enrollment\ManageEnrollments;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


// --- Comunidade ---
Route::middleware(['auth', 'role:community'])->group(function () {
    Route::get('/my-enrollments', MyEnrollments::class)->name('enrollments.my');
});

// --- Coordenador/Admin ---
Route::middleware(['auth', 'role:admin,coordinator'])->group(function () {
    Route::get('/activities/{activity}/enrollments', ManageEnrollments::class)->name('enrollments.manage');
    Route::get('/inscricoes', ManageEnrollments::class)
        ->name('enrollments.manage');
});
Route::get('/', ActivityList::class)
    ->name('home');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'role:admin,coordinator'])->group(function () {

    Route::get('/activities', ManageActivities::class)->name('activities.manage');
    // Rota de Gestão de Projetos
    Route::get('projects', ManageProjects::class)->name('projects.manage');

    // Futuras rotas de gestão de atividades, relatórios, etc.
});

// Rota de logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__ . '/auth.php';
