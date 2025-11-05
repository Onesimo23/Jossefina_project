<?php

namespace App\Livewire\Activity;

use Livewire\Component;
use App\Models\Activity;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class ActivitiesShowcase extends Component
{
    public $activities = [];
    public $selectedActivity = null;
    public $showActivityModal = false;

    public $search = '';
    public $projectFilter = '';

    public $userEnrollments = [];

    public function mount()
    {
        $this->loadActivities();
        $this->loadUserEnrollments();
    }

    public function updatedSearch()
    {
        $this->loadActivities();
    }

    public function updatedProjectFilter()
    {
        $this->loadActivities();
    }

    private function loadActivities()
    {
        $query = Activity::query()
            ->with('project')
            ->where('status', 'scheduled');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        if ($this->projectFilter) {
            $query->where('project_id', $this->projectFilter);
        }

        $this->activities = $query->orderBy('start_date', 'asc')->get();
    }

    private function loadUserEnrollments()
    {
        if (Auth::check() && Auth::user()->role === 'community') {
            $this->userEnrollments = Enrollment::where('user_id', Auth::id())->pluck('activity_id')->toArray();
        }
    }

    public function openActivityModal($id)
    {
        $this->selectedActivity = Activity::with(['project'])->findOrFail($id);
        $this->showActivityModal = true;
    }

    public function closeModal()
    {
        $this->selectedActivity = null;
        $this->showActivityModal = false;
    }

    public function toggleEnrollment($activityId)
    {
        if (!Auth::check() || Auth::user()->role !== 'community') {
            return redirect()->route('login');
        }

        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('activity_id', $activityId)
            ->first();

        if ($enrollment) {
            // cancelar inscrição
            $enrollment->delete();
            session()->flash('message', 'Inscrição cancelada com sucesso.');
        } else {
            // verificar se há vagas
            $activity = Activity::findOrFail($activityId);
            $currentEnrollments = Enrollment::where('activity_id', $activityId)->count();

            if ($currentEnrollments >= $activity->required_slots) {
                session()->flash('message', 'Não há mais vagas disponíveis nesta atividade.');
                return;
            }

            Enrollment::create([
                'user_id' => Auth::id(),
                'activity_id' => $activityId,
                'status' => 'pending',
            ]);

            session()->flash('message', 'Inscrição realizada com sucesso!');
        }

        $this->loadUserEnrollments();
    }

    public function render()
    {
        return view('livewire.activity.activities-showcase', [
            'activities' => $this->activities,
            'userEnrollments' => $this->userEnrollments,
            'selectedActivity' => $this->selectedActivity,
        ]);
    }
}
