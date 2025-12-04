<?php

namespace App\Livewire\Activity;

use App\Models\Activity;
use App\Models\Project;
use app\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ManageActivities extends Component {
    use WithPagination;

    // Propriedades para a busca e filtro
    public $search = '';
    public $statusFilter = '';
    public $projectFilter = '';

    // Propriedades para o formulário (modal de criação/edição)
    public $activityId = null;
    public $project_id = '';
    public $title = '';
    public $description = '';
    public $start_date = '';
    public $end_date = '';
    public $location = '';
    public $required_slots = 1;
    public $status = 'draft';
    public $showModal = false;

    // Propriedades para o modal de Chat (Gerenciado via Livewire/Alpine)
    public $showChatModal = false;
    public $chatActivityId = null;

    // Regras de validação
    protected $rules = [
        'project_id' => 'required|exists:projects,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'location' => 'nullable|string|max:255',
        'required_slots' => 'required|integer|min:1',
        'status' => 'required|in:draft,scheduled,in_progress,completed,cancelled',
    ];

    public function mount() {
        // $this->authorize('viewAny', Activity::class);
    }


    public function openChat($activityId) {
        $this->chatActivityId = $activityId;
        $this->showChatModal = true;

        // Opcional: Para forçar o scroll na primeira abertura do chat.
        $this->dispatch('message-sent')->self();
    }

    public function closeChat() {
        $this->showChatModal = false;
        $this->chatActivityId = null;
    }

    public function render() {
        // 1. Consulta base
        $query = Activity::with('project');

        // 2. Aplicar filtros e busca
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->projectFilter) {
            $query->where('project_id', $this->projectFilter);
        }

        // Restrição opcional para coordenadores: mostrar apenas atividades dos seus projetos
        if (auth()->check() && auth()->user()->role === 'coordinator') {
            $projectIds = Project::where('coordinator_id', auth()->id())->pluck('id');
            $query->whereIn('project_id', $projectIds);
        }

        $activities = $query->latest('start_date')->paginate(10);

        // 3. Buscar Projetos disponíveis para o <select>
        $projects = Project::where('status', 'published')->get(['id', 'title']);

        return view('livewire.activity.manage-activities', [
            'activities' => $activities,
            'projects' => $projects,
        ])->layout('layouts.app');
    }


    public function openCreateModal() {
        $this->resetForm();
        // $this->authorize('create', Activity::class);
        $this->showModal = true;
    }

    public function edit(Activity $activity) {
        // $this->authorize('update', $activity);

        $this->activityId = $activity->id;
        $this->project_id = $activity->project_id;
        $this->title = $activity->title;
        $this->description = $activity->description;
        $this->start_date = $activity->start_date;
        $this->end_date = $activity->end_date;
        $this->location = $activity->location;
        $this->required_slots = $activity->required_slots;
        $this->status = $activity->status;

        $this->showModal = true;
    }

    public function save() {
        $this->validate();

        $data = $this->only([
            'project_id',
            'title',
            'description',
            'start_date',
            'end_date',
            'location',
            'required_slots',
            'status'
        ]);

        if ($this->activityId) {
            // Edição
            $activity = Activity::findOrFail($this->activityId);
            // $this->authorize('update', $activity);
            $activity->update($data);
        } else {
            // Criação
            // $this->authorize('create', Activity::class);
            Activity::create($data);
        }

        $this->showModal = false;
        $this->resetForm();
        $this->dispatch('activity-saved')->self();
    }

    public function delete(Activity $activity) {
        // $this->authorize('delete', $activity);
        $activity->delete();
        $this->dispatch('activity-deleted')->self();
    }

    // --- Métodos de Auxílio ---

    protected function resetForm() {
        $this->resetValidation();
        $this->reset([
            'activityId',
            'title',
            'description',
            'start_date',
            'end_date',
            'location',
            'required_slots',
            'status'
        ]);
        // Manter o projeto ID ou resetar, dependendo do contexto.
        // Neste caso, vamos resetar o project_id, mas mantemos required_slots com 1 por default.
        $this->project_id = '';
        $this->required_slots = 1;
        $this->status = 'draft';
    }

    public function updatingSearch() {
        $this->resetPage();
    }
    public function updatingStatusFilter() {
        $this->resetPage();
    }
    public function updatingProjectFilter() {
        $this->resetPage();
    }
}
