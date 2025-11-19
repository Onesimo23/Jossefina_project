<?php

namespace App\Livewire\Project;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class ManageProjects extends Component {
    use WithPagination;

    // Propriedades para a busca e filtro da tabela
    public $search = '';
    public $statusFilter = '';
    public $showChatModal = false;
    public $chatActivityId = null;


    // Propriedades para o formulário (modal de criação/edição)
    public $projectId = null;
    public $title = '';
    public $description = '';
    public $coordinator_id;
    public $start_date = '';
    public $end_date = '';
    public $status = 'draft';
    public $objectives = '';
    public $expected_results = '';
    public $target_audience = '';
    public $area_of_activity = '';

    public $showModal = false;

    // Regras de validação (com base nos campos da migração)
    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'coordinator_id' => 'required|exists:users,id',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'status' => 'required|in:draft,published,archived',
        // Novos campos adicionados para gestão
        'objectives' => 'nullable|string',
        'expected_results' => 'nullable|string',
        'target_audience' => 'nullable|string|max:255',
        'area_of_activity' => 'nullable|string|max:255',
    ];

    public function mount() {
        // 1. Autorização: Verifica se o usuário pode ACESSAR a tela de gestão (viewAny na Policy)
        $this->authorize('viewAny', Project::class);

        // 2. Definir o Coordenador padrão se for criação e o usuário for coordenador
        if (auth()->user()->role === 'coordinator') {
            $this->coordinator_id = auth()->id();
        }
    }

    public function openChat($activityId) {
        $this->chatActivityId = $activityId;
        $this->showChatModal = true;
    }


    public function render() {
        // 1. Consulta base
        $query = Project::with('coordinator');

        // 2. Aplicar filtros e busca
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('area_of_activity', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // 3. Restrição para Coordenadores: Mostrar apenas seus próprios projetos
        if (auth()->user()->role === 'coordinator' && auth()->user()->role !== 'admin') {
            $query->where('coordinator_id', auth()->id());
        }

        $projects = $query->paginate(10);

        // 4. Buscar Coordenadores disponíveis para o <select> no modal
        $coordinators = \App\Models\User::whereIn('role', ['admin', 'coordinator'])->get(['id', 'name']);

        return view('livewire.project.manage-projects', [
            'projects' => $projects,
            'coordinators' => $coordinators,
        ])->layout('layouts.app');
    }

    // --- Métodos do Modal e CRUD ---

    public function openCreateModal() {
        $this->resetForm();
        // A autorização de criação está implícita no botão da view, mas é bom garantir.
        $this->authorize('create', Project::class);
        $this->showModal = true;
    }

    public function edit(Project $project) {
        // Autorização: O usuário só pode editar se for o coordenador do projeto ou admin.
        $this->authorize('update', $project);

        $this->projectId = $project->id;
        // Preencher as propriedades do formulário com os dados do projeto
        $this->title = $project->title;
        $this->description = $project->description;
        $this->coordinator_id = $project->coordinator_id;
        $this->start_date = $project->start_date;
        $this->end_date = $project->end_date;
        $this->status = $project->status;
        $this->objectives = $project->objectives;
        $this->expected_results = $project->expected_results;
        $this->target_audience = $project->target_audience;
        $this->area_of_activity = $project->area_of_activity;

        $this->showModal = true;
    }

    public function save() {
        $this->validate();

        $data = $this->only([
            'title',
            'description',
            'coordinator_id',
            'start_date',
            'end_date',
            'status',
            'objectives',
            'expected_results',
            'target_audience',
            'area_of_activity'
        ]);

        if ($this->projectId) {
            // Edição
            $project = Project::findOrFail($this->projectId);
            $this->authorize('update', $project);
            $project->update($data);
        } else {
            // Criação
            $this->authorize('create', Project::class);
            Project::create($data);
        }

        $this->showModal = false;
        $this->resetForm();
        // Emitir evento para fechar o modal e atualizar a tabela
        $this->dispatch('project-saved')->self();
    }

    public function delete(Project $project) {
        // Autorização: O usuário só pode apagar se for o coordenador do projeto ou admin.
        $this->authorize('delete', $project);
        $project->delete();
        $this->dispatch('project-deleted')->self();
    }

    // --- Métodos de Auxílio ---

    protected function resetForm() {
        $this->resetValidation();
        $this->reset([
            'projectId',
            'title',
            'description',
            'start_date',
            'end_date',
            'status',
            'objectives',
            'expected_results',
            'target_audience',
            'area_of_activity'
        ]);
        // Manter o coordenador logado selecionado por padrão, se for um coordenador
        if (auth()->user()->role === 'coordinator') {
            $this->coordinator_id = auth()->id();
        } else {
            $this->coordinator_id = null;
        }
    }

    // Resetar a paginação ao fazer uma nova busca ou filtro
    public function updatingSearch() {
        $this->resetPage();
    }
    public function updatingStatusFilter() {
        $this->resetPage();
    }
}
