<div><x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestão de Atividades</h2></x-slot><div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            <!-- FERRAMENTAS DE FILTRO E BUSCA -->
            <div class="flex flex-col md:flex-row justify-between mb-4 space-y-4 md:space-y-0">
                <div class="md:w-1/3">
                    <input wire:model.live="search" type="text" placeholder="Buscar por título ou local..."
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class="flex space-x-4">
                    <select wire:model.live="projectFilter"
                        class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos os Projetos</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="statusFilter"
                        class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos os Status</option>
                        <option value="scheduled">Agendada</option>
                        <option value="draft">Rascunho</option>
                        <option value="completed">Concluída</option>
                        <option value="cancelled">Cancelada</option>
                    </select>

                    <!-- Botão de Criação -->
                    {{-- @can('create', \App\Models\Activity::class) --}}
                        <x-primary-button wire:click="openCreateModal">
                            Criar Nova Atividade
                        </x-primary-button>
                    {{-- @endcan --}}
                </div>
            </div>

            <!-- TABELA DE ATIVIDADES -->
            <!-- overflow-x-auto garante scroll horizontal em ecrãs pequenos -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">Título</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">Projeto</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Datas</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">Vagas</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Status</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($activities as $activity)
                            <tr wire:key="activity-{{ $activity->id }}">
                                <!-- TÍTULO -->
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 truncate max-w-xs" title="{{ $activity->title }}">
                                    {{ $activity->title }}
                                </td>
                                <!-- PROJETO -->
                                <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">
                                    {{ $activity->project->title ?? 'N/A' }}
                                </td>
                                <!-- DATAS -->
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($activity->start_date)->format('d/m/Y') }}
                                    @if ($activity->end_date)
                                        - {{ \Carbon\Carbon::parse($activity->end_date)->format('d/m/Y') }}
                                    @endif
                                </td>
                                <!-- VAGAS -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    {{ $activity->approved_enrollments_count }}/{{ $activity->required_slots }}
                                </td>
                                <!-- STATUS -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        // Define as classes para o badge de Status
                                        $badgeClasses = [
                                            'scheduled' => 'bg-indigo-100 text-indigo-800',
                                            'draft' => 'bg-yellow-100 text-yellow-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ][$activity->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClasses }}">
                                        {{ ucfirst($activity->status) }}
                                    </span>
                                </td>
                                <!-- AÇÕES -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                                    {{-- @can('update', $activity) --}}
                                        <a wire:click="edit({{ $activity->id }})" class="text-indigo-600 hover:text-indigo-900 cursor-pointer">Editar</a>
                                    {{-- @endcan --}}
                                    {{-- @can('delete', $activity) --}}
                                        <a wire:click="delete({{ $activity->id }})" class="text-red-600 hover:text-red-900 cursor-pointer">Apagar</a>
                                    {{-- @endcan --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Nenhuma atividade encontrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE CRIAÇÃO/EDIÇÃO DE ATIVIDADE (Não alterado) -->
<div
    x-data="{ show: @entangle('showModal').live }"
    x-show="show"
    x-trap.noscroll="show"
    style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-title"
>
    <!-- Backdrop -->
    <div x-show="show" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity duration-300" x-transition:enter="ease-out duration-300" x-transition:leave="ease-in duration-200"></div>

    <!-- Conteúdo do Modal -->
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:leave="ease-in duration-200 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="flex items-center justify-center min-h-full p-4 text-center sm:p-0"
    >
        <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:w-full sm:max-w-4xl"
            @click.outside="show = false"
            @keydown.escape.window="show = false"
        >
            <!-- Header -->
            <div class="bg-indigo-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800" id="modal-title">
                    {{ $activityId ? 'Editar Atividade' : 'Criar Nova Atividade' }}
                </h3>
                <button wire:click="$set('showModal', false)" type="button" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Body (Content) -->
            <div class="p-6">
                <form wire:submit.prevent="save" id="activityForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Projeto Associado -->
                        <div class="col-span-full md:col-span-1">
                            <x-input-label for="project_id" value="Projeto Principal" />
                            <select wire:model="project_id" id="project_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">Selecione o Projeto</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('project_id')" />
                        </div>

                        <!-- Título da Atividade -->
                        <div class="col-span-full md:col-span-1">
                            <x-input-label for="title" value="Título da Atividade" />
                            <x-text-input wire:model="title" id="title" type="text" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <!-- Localização -->
                        <div class="col-span-full md:col-span-1">
                            <x-input-label for="location" value="Localização" />
                            <x-text-input wire:model="location" id="location" type="text" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>

                        <!-- Vagas Necessárias -->
                        <div class="col-span-full md:col-span-1">
                            <x-input-label for="required_slots" value="Vagas Necessárias" />
                            <x-text-input wire:model="required_slots" id="required_slots" type="number" min="1" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('required_slots')" />
                        </div>

                        <!-- Data de Início -->
                        <div class="col-span-full md:col-span-1">
                            <x-input-label for="start_date" value="Data de Início" />
                            <x-text-input wire:model="start_date" id="start_date" type="date" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                        </div>

                        <!-- Data de Fim -->
                        <div class="col-span-full md:col-span-1">
                            <x-input-label for="end_date" value="Data de Fim (Previsão)" />
                            <x-text-input wire:model="end_date" id="end_date" type="date" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                        </div>

                        <!-- Status -->
                        <div class="col-span-full md:col-span-1">
                            <x-input-label for="status" value="Status" />
                            <select wire:model="status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                <option value="draft">Rascunho</option>
                                <option value="scheduled">Agendada</option>
                                <option value="completed">Concluída</option>
                                <option value="cancelled">Cancelada</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <!-- Descrição -->
                        <div class="col-span-full">
                            <x-input-label for="description" value="Descrição Detalhada" />
                            <textarea wire:model="description" id="description" rows="5" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end items-center space-x-2">
                <x-secondary-button wire:click="$set('showModal', false)">
                    Cancelar
                </x-secondary-button>

                <x-primary-button wire:click="save" wire:loading.attr="disabled" form="activityForm">
                    {{ $activityId ? 'Salvar Alterações' : 'Criar Atividade' }}
                </x-primary-button>
            </div>
        </div>
    </div>
</div>
</div>
