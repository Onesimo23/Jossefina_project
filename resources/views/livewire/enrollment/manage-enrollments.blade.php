<div class="py-10 max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Gestão de Inscrições</h1>

    {{-- Filtros --}}
    <div class="mb-6 flex flex-col md:flex-row gap-4">
        <input type="text" wire:model.live="search" placeholder="Buscar participante..."
            class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full md:w-1/3">

        <select wire:model.live="activityFilter"
            class="border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full md:w-1/3">
            <option value="">Todas as Atividades</option>
            @foreach($activities as $act)
            <option value="{{ $act->id }}">{{ $act->title }} — {{ $act->project->title }}</option>
            @endforeach
        </select>
    </div>

    {{-- Mensagens --}}
    @if (session()->has('message'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('message') }}
    </div>
    @endif

    @if (session()->has('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        {{ session('error') }}
    </div>
    @endif

    {{-- Tabela --}}
    <div class="overflow-x-auto bg-white dark:bg-zinc-800 rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
            <thead class="bg-gray-100 dark:bg-zinc-700">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Participante</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Atividade</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Projeto</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Status</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                @forelse($enrollments as $enroll)
                <tr>
                    <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                        {{ $enroll->user->name }}<br>
                        <span class="text-sm text-gray-500">{{ $enroll->user->email }}</span>
                    </td>
                    <td class="px-4 py-3">{{ $enroll->activity->title }}</td>
                    <td class="px-4 py-3">{{ $enroll->activity->project->title }}</td>
                    <td class="px-4 py-3">
                        @switch($enroll->status)
                        @case('approved')
                        <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">Aprovada</span>
                        @break
                        @case('rejected')
                        <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full">Rejeitada</span>
                        @break
                        @case('cancelled')
                        <span class="px-3 py-1 text-xs bg-gray-200 text-gray-700 rounded-full">Cancelada</span>
                        @break
                        @default
                        <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">Pendente</span>
                        @endswitch
                    </td>
                    <td class="px-4 py-3 flex gap-2">
                        @if($enroll->status === 'pending')
                        <x-primary-button wire:click="approve({{ $enroll->id }})">Aprovar</x-primary-button>
                        <x-danger-button wire:click="reject({{ $enroll->id }})">Rejeitar</x-danger-button>
                        @elseif(in_array($enroll->status, ['approved', 'rejected']))
                        <!-- <x-secondary-button wire:click="cancel({{ $enroll->id }})">Cancelar</x-secondary-button> -->
                        @endif
                        <x-secondary-button wire:click="edit({{ $enroll->id }})">Editar</x-secondary-button>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Nenhuma inscrição encontrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Modal de edit -->
    @if($editMode)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                Editar Status da Inscrição
            </h2>

            <div class="mb-4">
                <label for="newStatus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Novo Status
                </label>
                <select wire:model="newStatus" id="newStatus"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="pending">Pendente</option>
                    <option value="approved">Aprovada</option>
                    <option value="rejected">Rejeitada</option>
                    <option value="cancelled">Cancelada</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <!-- <x-secondary-button wire:click="$set('editMode', false)">Cancelar</x-secondary-button> -->
                <x-primary-button wire:click="updateStatus">Salvar</x-primary-button>
            </div>
        </div>
    </div>
    @endif

</div>
