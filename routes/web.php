<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Project\ManageProjects;
use App\Livewire\Activity\ManageActivities;
use App\Livewire\Public\ActivityList;
use App\Livewire\Enrollment\MyEnrollments;
use App\Livewire\Enrollment\ManageEnrollments;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DialogueNotificationController;
use App\Http\Controllers\ReportController;
use App\Livewire\Report\ManageReports;
use Illuminate\Support\Facades\Auth;


// --- Comunidade ---
Route::middleware(['auth', 'role:community'])->group(function () {
    Route::get('/my-enrollments', MyEnrollments::class)->name('enrollments.my');
});

// --- Coordenador/Admin ---
Route::middleware(['auth'])->group(function () {
    Route::get('/activities/{activity}/enrollments', ManageEnrollments::class)->name('enrollments.manage');
    Route::get('/inscricoes', ManageEnrollments::class)
        ->name('enrollments.manage');
    Route::get('/activities', ManageActivities::class)->name('activities.manage');
    Route::get('/reports', ManageReports::class)->name('reports.index');
    Route::get('/reports/download/{type}/{format}', [ReportController::class, 'download'])
        ->name('reports.download');
});
Route::get('/', ActivityList::class)
    ->name('home');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('/projects', ManageProjects::class)->name('projects.manage');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
    
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users', \App\Livewire\User\ManageUsers::class)->name('users.manage');
});


Route::get('/activity/{activity}', function (App\Models\Activity $activity) {
    return view('activity.show', compact('activity'));
})->middleware('auth');



Route::post('/logout', function () {
    Auth::guard()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dialogue/notifications/latest', [DialogueNotificationController::class, 'latest'])
        ->name('dialogue.notifications.latest');

    Route::post('/dialogue/notifications/mark-read', [DialogueNotificationController::class, 'markAllRead'])
        ->name('dialogue.notifications.markRead');
});

require __DIR__ . '/auth.php';
