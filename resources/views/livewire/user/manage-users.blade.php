<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gerenciamento de Usuários
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- MENSAGEM DE SUCESSO --}}
                @if(session()->has('message'))
                <div class="mx-6 mt-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg"
                     x-data="{ show: true }"
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => show = false, 5000)">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-green-700 font-medium">{{ session('message') }}</p>
                        </div>
                        <button @click="show = false" class="text-green-500 hover:text-green-700 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
                @endif

                <div class="p-6">
                    {{-- CABEÇALHO COM ESTATÍSTICAS --}}
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Usuários do Sistema</h3>
                                <p class="text-sm text-gray-500 mt-1">Gerencie todos os usuários da plataforma</p>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-indigo-600">{{ $users->total() }}</p>
                                <p class="text-xs text-gray-500">Total de usuários</p>
                            </div>
                        </div>
                    </div>

                    {{-- FILTRO E BUSCA --}}
                    <div class="flex flex-col md:flex-row gap-4 mb-6">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input wire:model.live.debounce.300ms="search"
                                       type="text"
                                       placeholder="Buscar por nome ou email..."
                                       class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                                <div wire:loading wire:target="search" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="animate-spin h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <x-primary-button wire:click="openModal" class="whitespace-nowrap">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Novo Usuário
                        </x-primary-button>
                    </div>

                    {{-- TABELA DE USUÁRIOS --}}
                    <div class="overflow-hidden border border-gray-200 rounded-lg">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Função</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($users as $user)
                                    <tr class="hover:bg-gray-50 transition-colors" wire:key="user-{{ $user->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                            $roleClasses = [
                                                'admin' => 'bg-red-100 text-red-800',
                                                'coordinator' => 'bg-blue-100 text-blue-800',
                                                'community' => 'bg-green-100 text-green-800',
                                            ][$user->role] ?? 'bg-gray-100 text-gray-800';

                                            $roleLabels = [
                                                'admin' => 'Administrador',
                                                'coordinator' => 'Coordenador',
                                                'community' => 'Comunidade',
                                            ];
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $roleClasses }}">
                                                {{ $roleLabels[$user->role] ?? ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-3">
                                            <button wire:click="openModal({{ $user->id }})"
                                                class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                                Editar
                                            </button>
                                            <button wire:click="confirmDelete({{ $user->id }})"
                                                class="text-red-600 hover:text-red-900 transition-colors">
                                                Remover
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3.5A1.5 1.5 0 012 19.5V5.5A1.5 1.5 0 013.5 4h17A1.5 1.5 0 0122 5.5v14a1.5 1.5 0 01-1.5 1.5z"></path>
                                            </svg>
                                            <p>Nenhum usuário encontrado</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- PAGINAÇÃO --}}
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================== MODAL DE CRIAÇÃO / EDIÇÃO ================== --}}
    <div
        x-data="{ show: @entangle('modalOpen').live }"
        x-show="show"
        x-trap.noscroll="show"
        style="display: none;"
        class="fixed inset-0 z-50 overflow-y-auto"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-title">

        <div x-show="show"
             @click="$set('modalOpen', false)"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity duration-300"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <div class="flex items-center justify-center min-h-full p-4 text-center sm:p-0">
            <div
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                @click.stop
                @keydown.escape.window="$set('modalOpen', false)"
                class="relative bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:w-full sm:max-w-lg">

                {{-- Header --}}
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-bold text-white" id="modal-title">
                                {{ $userId ? 'Editar Usuário' : 'Novo Usuário' }}
                            </h3>
                        </div>
                        <button wire:click="$set('modalOpen', false)"
                                type="button"
                                class="text-white/80 hover:text-white transition-colors rounded-lg p-1 hover:bg-white/10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Body --}}
                <div class="p-6">
                    <form wire:submit.prevent="save" id="userForm">
                        <div class="space-y-5">

                            <div>
                                <x-input-label for="name" value="Nome Completo" class="text-sm font-semibold text-gray-700" />
                                <div class="mt-2">
                                    <x-text-input wire:model="name" id="name" type="text" class="block w-full" placeholder="Digite o nome completo" />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" value="Email" class="text-sm font-semibold text-gray-700" />
                                <div class="mt-2">
                                    <x-text-input wire:model="email" id="email" type="email" class="block w-full" placeholder="Digite o email" />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="role" value="Função" class="text-sm font-semibold text-gray-700" />
                                <div class="mt-2">
                                    <select wire:model="role" id="role" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Selecione uma função</option>
                                        <option value="admin">Administrador</option>
                                        <option value="coordinator">Coordenador</option>
                                        <option value="community">Comunidade</option>
                                    </select>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('role')" />
                            </div>

                            <div>
                                <x-input-label for="password" value="Senha" class="text-sm font-semibold text-gray-700" />
                                @if($userId)
                                <p class="text-xs text-gray-500 mt-1 mb-2">Deixe em branco para manter a senha atual</p>
                                @endif
                                <div class="mt-2">
                                    <x-text-input wire:model="password" id="password" type="password" class="block w-full" placeholder="Digite a senha" />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>

                        </div>
                    </form>
                </div>

                {{-- Footer --}}
                <div class="bg-gray-50 px-6 py-4 flex justify-end items-center space-x-3 border-t">
                    <x-secondary-button wire:click="$set('modalOpen', false)" class="px-5">
                        Cancelar
                    </x-secondary-button>

                    <button type="submit"
                            form="userForm"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-150">
                        <span wire:loading.remove wire:target="save">
                            {{ $userId ? 'Salvar Alterações' : 'Criar Usuário' }}
                        </span>
                        <span wire:loading wire:target="save" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Salvando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ================== MODAL DE CONFIRMAÇÃO DE EXCLUSÃO ================== --}}
    <div
        x-data="{ show: @entangle('confirmDeleteOpen').live }"
        x-show="show"
        x-trap.noscroll="show"
        style="display: none;"
        class="fixed inset-0 z-50 overflow-y-auto"
        role="dialog"
        aria-modal="true"
        aria-labelledby="delete-modal-title">

        <div x-show="show"
             @click="$set('confirmDeleteOpen', false)"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity duration-300"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <div class="flex items-center justify-center min-h-full p-4 text-center sm:p-0">
            <div
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                @click.stop
                @keydown.escape.window="$set('confirmDeleteOpen', false)"
                class="relative bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:w-full sm:max-w-md">

                <div class="bg-white px-6 pt-6 pb-4">
                    {{-- Ícone de Alerta --}}
                    <div class="flex justify-center mb-4">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-red-100 ring-8 ring-red-50">
                            <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M12 3a9 9 0 110 18 9 9 0 010-18z"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Título e Descrição --}}
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-2" id="delete-modal-title">
                            Confirmar Remoção
                        </h3>
                        <p class="text-sm text-gray-600 mb-1">
                            Tem certeza que deseja remover este usuário?
                        </p>
                        <p class="text-xs text-gray-500">
                            Esta ação não pode ser desfeita e todos os dados serão perdidos permanentemente.
                        </p>
                    </div>
                </div>

                {{-- Footer com Ações --}}
                <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-center gap-3 border-t">
                    <x-secondary-button
                        wire:click="$set('confirmDeleteOpen', false)"
                        class="w-full sm:w-auto justify-center px-6">
                        Cancelar
                    </x-secondary-button>

                    <button
                        wire:click="delete"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-50 cursor-not-allowed"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-150">
                        <span wire:loading.remove wire:target="delete" class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Sim, Remover
                        </span>
                        <span wire:loading wire:target="delete" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Removendo...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
