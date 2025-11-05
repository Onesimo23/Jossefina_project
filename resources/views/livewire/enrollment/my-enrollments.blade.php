<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Minhas Inscrições</h2>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto">
        <div class="bg-white shadow sm:rounded-lg p-6">
            @if (session()->has('message'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('message') }}</div>
            @endif

            @if ($enrollments->isEmpty())
            <p class="text-gray-600">Não possui inscrições ativas.</p>
            @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Atividade</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Projeto</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($enrollments as $enrollment)
                    <tr>
                        <td class="px-4 py-2">{{ $enrollment->activity->title }}</td>
                        <td class="px-4 py-2">{{ $enrollment->activity->project->title ?? 'N/A' }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs
                                        @if($enrollment->status === 'approved') bg-green-100 text-green-700
                                        @elseif($enrollment->status === 'rejected') bg-red-100 text-red-700
                                        @else bg-yellow-100 text-yellow-700 @endif">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            @if($enrollment->status === 'pending')
                            <x-secondary-button wire:click="cancel({{ $enrollment->id }})">
                                Cancelar
                            </x-secondary-button>
                            @else
                            <span class="text-gray-400 text-sm italic">Para mais informações entre em contacto com o coordenador</span>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
