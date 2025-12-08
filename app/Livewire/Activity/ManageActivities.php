<?php

namespace App\Livewire\Activity;

use App\Models\Activity;
use App\Models\Project;
use app\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads; // <--- adicionado
use Illuminate\Support\Str;

class ManageActivities extends Component {
    use WithPagination, WithFileUploads; // <--- adicionado

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

    // Propriedades para upload de evidências (evita Undefined variable $photos)
    public $photos = [];
    public $caption = '';

    // modal de evidências separado do chat
    public $showEvidenceModal = false;
    public $evidenceActivityId = null;

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

    protected $evidenceRules = [
        'photos.*' => 'image|max:10240',
        'caption' => 'nullable|string|max:1000',
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

    // abre modal de evidências (botão na tabela)
    public function openEvidenceModal($activityId)
    {
        $this->evidenceActivityId = $activityId;
        $this->showEvidenceModal = true;
    }

    public function closeEvidenceModal()
    {
        $this->showEvidenceModal = false;
        $this->evidenceActivityId = null;
    }

    public function render() {
        // 1. Consulta base
        // traz também o contador de evidências para exibição na tabela
        $query = Activity::with('project')->withCount('evidences');

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

    // --- Métodos para evidências (upload temporário via Livewire) ---
    public function saveEvidence()
    {
        if (!$this->chatActivityId && !$this->activityId) {
            session()->flash('error', 'Selecione uma atividade antes de enviar evidências.');
            return;
        }

        // usa o activityId ativo (chatActivityId geralmente é o modal)
        $activityId = $this->chatActivityId ?? $this->activityId;

        $this->validate($this->evidenceRules);

        if (count($this->photos) === 0) {
            $this->addError('photos', 'Selecione ao menos uma foto.');
            return;
        }

        // cria registro de evidência
        $evidence = \App\Models\Evidence::create([
            'activity_id' => $activityId,
            'user_id' => auth()->id(),
            'caption' => $this->caption,
        ]);

        foreach ($this->photos as $photo) {
            $filename = 'evidences/' . $activityId . '/' . \Illuminate\Support\Str::random(20) . '.' . $photo->getClientOriginalExtension();
            $disk = 'public';
            $photo->storeAs('evidences/' . $activityId, basename($filename), $disk);

            \App\Models\EvidencePhoto::create([
                'evidence_id' => $evidence->id,
                'filename' => $filename,
                'disk' => $disk,
            ]);
        }

        $this->reset(['photos', 'caption']);
        $this->resetValidation();
        session()->flash('message', 'Evidências enviadas com sucesso.');
        $this->emit('evidenceUploaded', $activityId);
    }

    public function removePhoto($index)
    {
        if (isset($this->photos[$index])) {
            array_splice($this->photos, $index, 1);
        }
    }

    public function clearForm()
    {
        $this->reset(['photos', 'caption']);
        $this->resetValidation();
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
