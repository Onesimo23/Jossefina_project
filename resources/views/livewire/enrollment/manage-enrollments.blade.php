<div class="py-8 px-4 max-w-7xl mx-auto bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2 tracking-tight">Gestão de Inscrições</h1>
        <p class="text-lg text-gray-600">Gerencie e acompanhe todas as inscrições dos participantes</p>
    </div>

    <!-- Filtros -->
    <div class="mb-6 bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Buscar Participante
                </label>
                <div class="relative">
                    <input type="text" wire:model.live="search"
                        placeholder="Nome ou email do participante..."
                        class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 outline-none">
                    <svg class="absolute left-3.5 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Filtrar por Atividade
                </label>
                <select wire:model.live="activityFilter"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 outline-none bg-white">
                    <option value="">Todas as Atividades</option>
                    @foreach($activities as $act)
                    <option value="{{ $act->id }}">{{ $act->title }} — {{ $act->project->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Mensagens -->
    @if (session()->has('message'))
    <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl shadow-md flex items-start animate-fade-in">
        <svg class="h-6 w-6 text-green-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <p class="text-green-800 font-semibold">{{ session('message') }}</p>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-xl shadow-md flex items-start animate-fade-in">
        <svg class="h-6 w-6 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <p class="text-red-800 font-semibold">{{ session('error') }}</p>
    </div>
    @endif

    <!-- Tabela -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Participante
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Atividade
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Projeto
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($enrollments as $enroll)
                    <tr class="hover:bg-blue-50/50 transition-colors duration-150">
                        <td class="px-6 py-5">
                            <div class="flex items-center">
                                <div class="h-11 w-11 flex-shrink-0 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-md ring-2 ring-white">
                                    <span class="text-white font-bold text-base">{{ substr($enroll->user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="font-semibold text-gray-900 text-base">{{ $enroll->user->name }}</div>
                                    <div class="text-sm text-gray-600">{{ $enroll->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-sm font-semibold text-gray-900">{{ $enroll->activity->title }}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-sm text-gray-700 font-medium">{{ $enroll->activity->project->title }}</div>
                        </td>
                        <td class="px-6 py-5">
                            @switch($enroll->status)
                            @case('approved')
                            <span class="inline-flex items-center px-3.5 py-1.5 text-xs font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 rounded-full shadow-sm border border-green-200">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Aprovada
                            </span>
                            @break
                            @case('rejected')
                            <span class="inline-flex items-center px-3.5 py-1.5 text-xs font-bold bg-gradient-to-r from-red-100 to-pink-100 text-red-800 rounded-full shadow-sm border border-red-200">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                Rejeitada
                            </span>
                            @break
                            @case('cancelled')
                            <span class="inline-flex items-center px-3.5 py-1.5 text-xs font-bold bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 rounded-full shadow-sm border border-gray-200">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                </svg>
                                Cancelada
                            </span>
                            @break
                            @default
                            <span class="inline-flex items-center px-3.5 py-1.5 text-xs font-bold bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-800 rounded-full shadow-sm border border-amber-200">
                                <svg class="w-3.5 h-3.5 mr-1.5 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                Pendente
                            </span>
                            @endswitch
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                @if($enroll->status === 'pending')
                                <x-primary-button wire:click="approve({{ $enroll->id }})" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Aprovar
                                </x-primary-button>
                                <x-danger-button wire:click="reject({{ $enroll->id }})" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Rejeitar
                                </x-danger-button>
                                @endif
                                <x-secondary-button wire:click="edit({{ $enroll->id }})" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-lg border-2 border-gray-300 hover:border-gray-400 shadow-sm hover:shadow-md transition-all duration-200">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Editar
                                </x-secondary-button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-20 w-20 rounded-full bg-gradient-to-br from-gray-100 to-blue-100 flex items-center justify-center mb-4">
                                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-700 font-semibold text-lg mb-1">Nenhuma inscrição encontrada</p>
                                <p class="text-gray-500">Tente ajustar os filtros de pesquisa</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Edição -->
    @if($editMode)
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md transform transition-all animate-scale-in border border-gray-100">
            <!-- Header do Modal -->
            <div class="px-7 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-blue-50 rounded-t-3xl">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mr-3 shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    Editar Status da Inscrição
                </h2>
            </div>

            <!-- Conteúdo do Modal -->
            <div class="px-7 py-6">
                <label for="newStatus" class="block text-sm font-bold text-gray-700 mb-3">
                    Selecione o Novo Status
                </label>
                <select wire:model="newStatus" id="newStatus"
                    class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 outline-none bg-white font-medium text-gray-700">
                    <option value="pending">🕐 Pendente</option>
                    <option value="approved">✅ Aprovada</option>
                    <option value="rejected">❌ Rejeitada</option>
                    <option value="cancelled">🚫 Cancelada</option>
                </select>
            </div>

            <!-- Footer do Modal -->
            <div class="px-7 py-5 bg-gray-50 rounded-b-3xl flex justify-end gap-3 border-t border-gray-100">
                <x-secondary-button wire:click="$set('editMode', false)" class="inline-flex items-center px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-lg border-2 border-gray-300 hover:border-gray-400 shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancelar
                </x-secondary-button>
                <x-primary-button wire:click="updateStatus" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Salvar Alterações
                </x-primary-button>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scale-in {
            from { transform: scale(0.92); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .animate-fade-in {
            animation: fade-in 0.25s ease-out;
        }
        .animate-scale-in {
            animation: scale-in 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
    </style>
    @endif
</div>
