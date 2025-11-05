<?php

namespace App\Livewire\Enrollment;

use Livewire\Component;
use App\Models\Enrollment;
use App\Models\Activity;

class ManageEnrollments extends Component
{
    public $activityId;

    public function mount($activity)
    {
        $this->activityId = $activity;
    }

    public function render()
    {
        $activity = Activity::with(['enrollments.user'])->findOrFail($this->activityId);

        return view('livewire.enrollment.manage-enrollments', [
            'activity' => $activity,
        ])->layout('layouts.app');
    }

    public function updateStatus($enrollmentId, $status)
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);
        $enrollment->update(['status' => $status]);
    }

    public function remove($enrollmentId)
    {
        Enrollment::findOrFail($enrollmentId)->delete();
    }
}
