<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Activity;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class ActivityList extends Component {
    public $search = '';
    public $projectFilter = '';
    public $showActivityModal = false;
    public $selectedActivity = null;

    protected $listeners = ['openActivityModal' => 'openActivityModal'];

    public function render() {
        $query = Activity::with('project')
            ->where('status', 'scheduled');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
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

        // Contando usuários únicos inscritos em qualquer atividade
        $activeParticipants = Enrollment::distinct('user_id')->count('user_id');

        return view('livewire.public.activity-list', [
            'activities' => $activities,
            'userEnrollments' => $userEnrollments,
            'activeParticipants' => $activeParticipants,
        ])->layout('layouts.initial');
    }

    public function toggleEnrollment($activityId) {
        if (!Auth::check()) {
            return redirect()->route('login');
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
    }

    public function openActivityModal($id) {
        $this->selectedActivity = Activity::with(['project'])->findOrFail($id);
        $this->showActivityModal = true;
    }


    public function closeModal() {
        $this->showActivityModal = false;
        $this->selectedActivity = null;
    }

    public function enroll($activityId) {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $existing = Enrollment::where('user_id', Auth::id())
            ->where('activity_id', $activityId)
            ->first();

        if (!$existing) {
            Enrollment::create([
                'user_id' => Auth::id(),
                'activity_id' => $activityId,
                'status' => 'pending',
            ]);
            session()->flash('message', 'Inscrição realizada com sucesso!');
        }

        $this->closeModal();
    }

    public function unenroll($activityId) {
        $existing = Enrollment::where('user_id', Auth::id())
            ->where('activity_id', $activityId)
            ->first();

        if ($existing) {
            $existing->delete();
            session()->flash('message', 'Inscrição cancelada com sucesso.');
        }

        $this->closeModal();
    }
}
