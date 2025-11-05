<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gerir Inscrições — {{ $activity->title }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Participante</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-4 py-2 text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activity->enrollments as $enrollment)
                        <tr>
                            <td class="px-4 py-2">{{ $enrollment->user->name }}</td>
                            <td class="px-4 py-2">{{ $enrollment->user->email }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-xs
                                    @if($enrollment->status === 'approved') bg-green-100 text-green-700
                                    @elseif($enrollment->status === 'rejected') bg-red-100 text-red-700
                                    @else bg-yellow-100 text-yellow-700 @endif">
                                    {{ ucfirst($enrollment->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right space-x-2">
                                <x-secondary-button wire:click="updateStatus({{ $enrollment->id }}, 'approved')">Aprovar</x-secondary-button>
                                <x-danger-button wire:click="updateStatus({{ $enrollment->id }}, 'rejected')">Rejeitar</x-danger-button>
                                <x-secondary-button wire:click="remove({{ $enrollment->id }})">Remover</x-secondary-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
