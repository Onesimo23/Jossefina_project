<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Activity;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class ActivityList extends Component
{
    public $search = '';
    public $projectFilter = '';

    // Propriedades para o Modal
    public $showActivityModal = false;
    public $selectedActivity = null;

    // Listeners para abrir o modal ao clicar no card
    protected $listeners = ['openActivityModal'];

    public function openActivityModal($id)
    {
        // Carrega a atividade com o projeto e o coordenador para o modal
        $this->selectedActivity = Activity::with(['project.coordinator'])->find($id);
        if ($this->selectedActivity) {
            $this->showActivityModal = true;
        }
    }

    public function closeModal()
    {
        $this->showActivityModal = false;
        $this->selectedActivity = null;
    }

    public function render()
    {
        $query = Activity::with('project')
            ->where('status', 'scheduled');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->projectFilter) {
            $query->where('project_id', $this->projectFilter);
        }

        $activities = $query->orderBy('start_date', 'asc')->get();

        $userEnrollments = [];
        if (Auth::check()) {
            $userEnrollments = Enrollment::where('user_id', Auth::id())
                ->pluck('activity_id')
                ->toArray();
        }

        return view('livewire.public.activity-list', [
            'activities' => $activities,
            'userEnrollments' => $userEnrollments,
        ])->layout('layouts.initial');
    }

    public function toggleEnrollment($activityId)
    {
        if (!Auth::check()) {
            $this->showActivityModal = false;
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'community') {
            session()->flash('message', 'Apenas usuários da comunidade podem se inscrever.');
            return;
        }

        $existing = Enrollment::where('user_id', Auth::id())
            ->where('activity_id', $activityId)
            ->first();

        if ($existing) {
            $existing->delete();
            session()->flash('message', 'Inscrição cancelada com sucesso.');
        } else {
            Enrollment::create([
                'user_id' => Auth::id(),
                'activity_id' => $activityId,
                'status' => 'pending',
            ]);
            session()->flash('message', 'Inscrição realizada com sucesso!');
        }

        // Recarrega os dados
        $this->dispatch('$refresh');
    }
}
