<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-3">
                <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Minhas Inscrições
            </h2>
            <div class="text-sm text-gray-600 bg-gray-100 px-4 py-2 rounded-full">
                <span class="font-semibold">{{ $enrollments->count() }}</span> {{ $enrollments->count() === 1 ? 'inscrição' : 'inscrições' }}
            </div>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Mensagem de Sucesso -->
        @if (session()->has('message'))
        <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm animate-slideDown">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-green-700 font-medium">{{ session('message') }}</span>
            </div>
        </div>
        @endif

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">

            @if ($enrollments->isEmpty())

            <!-- Estado Vazio -->
            <div class="flex flex-col items-center justify-center py-20 px-6">
                <div class="w-32 h-32 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <svg class="w-16 h-16 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Nenhuma inscrição ainda</h3>
                <p class="text-gray-500 text-center max-w-md mb-6">
                    Você ainda não possui inscrições ativas. Explore as atividades disponíveis e inscreva-se nas que mais interessam!
                </p>
                <a href="{{ route('activities.index') }}"
                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all duration-200 hover:scale-105 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Explorar Atividades
                </a>
            </div>

            @else

            <!-- Lista de Inscrições (Desktop) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-slate-50">
                        <tr>
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
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($enrollments as $enrollment)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold mr-3 shadow-md">
                                        {{ substr($enrollment->activity->title, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $enrollment->activity->title }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            Inscrito em {{ $enrollment->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $enrollment->activity->project->title ?? '—' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($enrollment->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border border-green-200 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Aprovado
                                </span>
                                @elseif($enrollment->status === 'rejected')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-red-100 to-rose-100 text-red-700 border border-red-200 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Rejeitado
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-700 border border-yellow-200 shadow-sm">
                                    <svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Pendente
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($enrollment->status === 'pending')
                                    <button wire:click="cancel({{ $enrollment->id }})"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-150 shadow-sm hover:shadow">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Cancelar
                                    </button>
                                    @elseif($enrollment->status === 'rejected')
                                    <div class="text-xs text-gray-500 italic max-w-[200px] text-right">
                                        Entre em contacto com o coordenador para mais informações
                                    </div>
                                    @endif

                                    @if($enrollment->status === 'approved' && $enrollment->activity)
                                    <div x-data="{ showChat: false }" class="relative">
                                        <button @click="showChat = true"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg text-sm font-semibold hover:shadow-lg transition-all duration-200 hover:scale-105">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            Chat
                                        </button>

                                        <!-- Modal do Chat -->
                                        <div x-show="showChat"
                                            x-transition.opacity.duration.300ms
                                            class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                            style="display: none;">
                                            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showChat = false"></div>
                                            <div x-show="showChat"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0 transform scale-95"
                                                x-transition:enter-end="opacity-100 transform scale-100"
                                                class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl z-50 overflow-hidden">

                                                <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-slate-50 flex justify-between items-center">
                                                    <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2">
                                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                        </svg>
                                                        {{ $enrollment->activity->title }}
                                                    </h3>
                                                    <button @click="showChat = false"
                                                        class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-colors">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <div class="max-h-[70vh] overflow-y-auto">
                                                    @livewire('activity.activity-chat', ['activity' => $enrollment->activity], key('enroll-chat-'.$enrollment->id))
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Cards para Mobile -->
            <div class="md:hidden divide-y divide-gray-100">
                @foreach ($enrollments as $enrollment)
                <div class="p-5 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-start gap-3 flex-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold shadow-md flex-shrink-0">
                                {{ substr($enrollment->activity->title, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-gray-900 mb-1">
                                    {{ $enrollment->activity->title }}
                                </h4>
                                <p class="text-xs text-gray-500 mb-2">
                                    {{ $enrollment->activity->project->title ?? 'Sem projeto' }}
                                </p>
                                @if($enrollment->status === 'approved')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Aprovado
                                </span>
                                @elseif($enrollment->status === 'rejected')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Rejeitado
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Pendente
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2 mt-4">
                        @if($enrollment->status === 'pending')
                        <button wire:click="cancel({{ $enrollment->id }})"
                            class="flex-1 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </button>
                        @endif

                        @if($enrollment->status === 'approved' && $enrollment->activity)
                        <div x-data="{ showChat: false }" class="flex-1">
                            <button @click="showChat = true"
                                class="w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg text-sm font-semibold flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Chat
                            </button>

                            <!-- Modal Mobile -->
                            <div x-show="showChat"
                                x-transition.opacity
                                class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
                                style="display: none;">
                                <div class="absolute inset-0 bg-black/60" @click="showChat = false"></div>
                                <div x-show="showChat"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform translate-y-full"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    class="relative w-full sm:max-w-3xl bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl z-50 max-h-[90vh] flex flex-col">

                                    <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                                        <h3 class="font-bold text-base text-gray-800">{{ $enrollment->activity->title }}</h3>
                                        <button @click="showChat = false" class="text-gray-500 hover:text-gray-700 p-1">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="flex-1 overflow-y-auto">
                                        @livewire('activity.activity-chat', ['activity' => $enrollment->activity], key('enroll-chat-mobile-'.$enrollment->id))
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($enrollment->status === 'rejected')
                    <p class="text-xs text-gray-500 italic mt-3">
                        Entre em contacto com o coordenador para mais informações
                    </p>
                    @endif
                </div>
                @endforeach
            </div>

            @endif
        </div>
    </div>

    <style>
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }
</style>
</div>
