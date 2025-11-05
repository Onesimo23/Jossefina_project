<?php

namespace App\Livewire\Enrollment;

use Livewire\Component;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class MyEnrollments extends Component
{
    public function render()
    {
        $enrollments = Enrollment::with('activity.project')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('livewire.enrollment.my-enrollments', [
            'enrollments' => $enrollments,
        ])->layout('layouts.app');
    }

    public function cancel($id)
    {
        $enrollment = Enrollment::findOrFail($id);

        if ($enrollment->user_id !== Auth::id()) {
            abort(403);
        }

        $enrollment->delete();

        session()->flash('message', 'Inscrição cancelada com sucesso.');
    }
}
