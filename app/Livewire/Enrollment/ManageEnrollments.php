<?php

namespace App\Livewire\Enrollment;

use Livewire\Component;
use App\Models\Enrollment;
use App\Models\Activity;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ManageEnrollments extends Component {
    public $activityFilter = '';
    public $search = '';
    public $editMode = false;
    public $selectedEnrollment;
    public $newStatus;

    public function render() {
        $query = Enrollment::with(['user', 'activity.project'])
            ->orderByDesc('created_at');

        // Se for coordenador, mostra apenas as atividades dos projetos que coordena
        if (Auth::user()->role === 'coordinator') {
            $projectIds = Project::where('coordinator_id', Auth::id())->pluck('id');
            $activityIds = Activity::whereIn('project_id', $projectIds)->pluck('id');
            $query->whereIn('activity_id', $activityIds);
        }

        if ($this->activityFilter) {
            $query->where('activity_id', $this->activityFilter);
        }

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        $enrollments = $query->get();

        $activities = Activity::with('project')
            ->when(Auth::user()->role === 'coordinator', function ($q) {
                $projectIds = Project::where('coordinator_id', Auth::id())->pluck('id');
                $q->whereIn('project_id', $projectIds);
            })
            ->get();

        return view('livewire.enrollment.manage-enrollments', [
            'enrollments' => $enrollments,
            'activities' => $activities,
        ])->layout('layouts.app');
    }

    public function approve($id) {
        $enrollment = Enrollment::findOrFail($id);
        $activity = $enrollment->activity;

        // Verifica Inscrições disponíveis
        $approvedCount = Enrollment::where('activity_id', $activity->id)
            ->where('status', 'approved')
            ->count();

        if ($approvedCount >= $activity->required_slots) {
            session()->flash('error', 'Não há mais Inscrições disponíveis para esta atividade.');
            return;
        }

        $enrollment->update(['status' => 'approved']);
        session()->flash('message', 'Inscrição aprovada com sucesso!');
    }

    public function cancel($id) {
        $enroll = Enrollment::findOrFail($id);

        if (!in_array(auth()->user()->role, ['admin', 'coordinator'])) {
            session()->flash('error', 'Acesso negado.');
            return;
        }

        if ($enroll->status === 'cancelled') {
            session()->flash('error', 'Esta inscrição já foi cancelada.');
            return;
        }

        $enroll->update(['status' => 'cancelled']);

        session()->flash('message', 'Inscrição marcada como cancelada.');
    }


    public function reject($id) {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update(['status' => 'rejected']);
        session()->flash('message', 'Inscrição rejeitada.');
    }

    public function edit($id) {
        $this->selectedEnrollment = \App\Models\Enrollment::findOrFail($id);
        $this->newStatus = $this->selectedEnrollment->status;
        $this->editMode = true;
    }

    public function updateStatus() {
        if (!$this->selectedEnrollment) return;

        $this->validate([
            'newStatus' => 'required|in:pending,approved,rejected,cancelled',
        ]);

        $this->selectedEnrollment->update([
            'status' => $this->newStatus,
        ]);

        $this->reset(['editMode', 'selectedEnrollment', 'newStatus']);

        session()->flash('message', 'Status atualizado com sucesso.');
    }
}
