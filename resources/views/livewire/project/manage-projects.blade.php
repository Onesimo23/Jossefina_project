<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestão de Projetos de Extensão
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- FERRAMENTAS DE FILTRO E BUSCA -->
                <div class="flex flex-col md:flex-row justify-between mb-4">
                    <div class="mb-4 md:mb-0 md:w-1/3">
                        <input wire:model.live="search" type="text" placeholder="Buscar por título ou área..."
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="flex space-x-4">
                        <select wire:model.live="statusFilter"
                            class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todos os Status</option>
                            <option value="published">Publicado</option>
                            <option value="draft">Rascunho</option>
                            <option value="archived">Arquivado</option>
                        </select>

                        @can('create', \App\Models\Project::class)
                            <!-- O click abre o modal -->
                            <x-primary-button wire:click="openCreateModal">
                                Criar Novo Projeto
                            </x-primary-button>
                        @endcan
                    </div>
                </div>

                <!-- TABELA DE PROJETOS -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coordenador</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Área</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($projects as $project)
                                <tr wire:key="project-{{ $project->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $project->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $project->coordinator->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $project->area_of_activity ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($project->status === 'published') bg-green-100 text-green-800
                                            @elseif($project->status === 'draft') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @can('update', $project)
                                            <a wire:click="edit({{ $project->id }})" class="text-indigo-600 hover:text-indigo-900 cursor-pointer mr-3">Editar</a>
                                        @endcan
                                        @can('delete', $project)
                                            <a wire:click="delete({{ $project->id }})" class="text-red-600 hover:text-red-900 cursor-pointer">Apagar</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nenhum projeto encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- ESTRUTURA DO MODAL BOOTSTRAP CONTROLADA POR LIVEWIRE/ALPINE.JS -->
    <!-- Alpine.js é usado para sincronizar 'showModal' com a exibição do modal -->
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
        <!-- Backdrop (Plano de Fundo Escuro) -->
        <div x-show="show" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity duration-300" x-transition:enter="ease-out duration-300" x-transition:leave="ease-in duration-200"></div>

        <!-- Conteúdo do Modal (Estrutura do Bootstrap) -->
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
                        {{ $projectId ? 'Editar Projeto' : 'Criar Novo Projeto' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" type="button" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Body (Content) -->
                <div class="p-6">
                    <form wire:submit.prevent="save" id="projectForm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="col-span-full">
                                <x-input-label for="title" value="Título do Projeto" />
                                <x-text-input wire:model="title" id="title" type="text" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>

                            <div class="col-span-full md:col-span-1">
                                <x-input-label for="coordinator_id" value="Coordenador" />
                                <select wire:model="coordinator_id" id="coordinator_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="">Selecione o Coordenador</option>
                                    {{-- Assumindo que $coordinators está disponível no componente Livewire --}}
                                    @foreach ($coordinators as $coordinator)
                                        <option value="{{ $coordinator->id }}">{{ $coordinator->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('coordinator_id')" />
                            </div>

                            <div class="col-span-full md:col-span-1">
                                <x-input-label for="area_of_activity" value="Área de Atuação" />
                                <x-text-input wire:model="area_of_activity" id="area_of_activity" type="text" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('area_of_activity')" />
                            </div>

                            <div class="col-span-full md:col-span-1">
                                <x-input-label for="target_audience" value="Público-Alvo" />
                                <x-text-input wire:model="target_audience" id="target_audience" type="text" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('target_audience')" />
                            </div>

                            <div class="col-span-full md:col-span-1">
                                <x-input-label for="status" value="Status" />
                                <select wire:model="status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                    <option value="draft">Rascunho</option>
                                    <option value="published">Publicado</option>
                                    <option value="archived">Arquivado</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <div class="col-span-full md:col-span-1">
                                <x-input-label for="start_date" value="Data de Início" />
                                <x-text-input wire:model="start_date" id="start_date" type="date" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                            </div>

                            <div class="col-span-full md:col-span-1">
                                <x-input-label for="end_date" value="Data de Fim (Previsão)" />
                                <x-text-input wire:model="end_date" id="end_date" type="date" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="objectives" value="Objetivos do Projeto" />
                                <textarea wire:model="objectives" id="objectives" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"></textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('objectives')" />
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="expected_results" value="Resultados Esperados" />
                                <textarea wire:model="expected_results" id="expected_results" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"></textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('expected_results')" />
                            </div>

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

                    <x-primary-button wire:click="save" wire:loading.attr="disabled" form="projectForm">
                        {{ $projectId ? 'Salvar Alterações' : 'Criar Projeto' }}
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>
