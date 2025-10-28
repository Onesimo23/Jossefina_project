<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Project\ManageProjects;
use App\Livewire\Activity\ManageActivities;


Route::view('/', 'welcome');

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
require __DIR__ . '/auth.php';
