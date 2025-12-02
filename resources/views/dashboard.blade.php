<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #0077b6;">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- MENSAGEM DE BOAS-VINDAS --}}
        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 text-white rounded-xl p-6 shadow-lg">
            <h1 class="text-2xl font-bold text-white">
                Olá, {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-sm text-white/90 mt-1">
                @if(in_array(auth()->user()->role, ['admin', 'coordinator']))
                    Gerencie, monitore e tenha uma visão completa das atividades e projetos de extensão universitária.
                @else
                    Acompanhe suas inscrições e participe das atividades de extensão disponíveis para você.
                @endif
            </p>
        </div>

        {{-- PAINEL DIFERENCIADO POR FUNÇÃO --}}
        @if(in_array(auth()->user()->role, ['admin', 'coordinator']))
            {{-- DASHBOARD ADMIN/COORDENADOR --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Visão Geral</h3>
                <div class="grid md:grid-cols-3 gap-6">

                    {{-- Card: Projetos --}}
                    <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow hover:shadow-xl transition-shadow duration-200">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-200">Projetos</h4>
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-indigo-600">
                            {{ number_format(\App\Models\Project::count(), 0, ',', '.') }}
                        </p>
                        <a href="{{ route('projects.manage') }}" class="text-sm text-indigo-500 hover:underline mt-2 block transition-colors">
                            Gerir Projetos →
                        </a>
                    </div>

                    {{-- Card: Atividades --}}
                    <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow hover:shadow-xl transition-shadow duration-200">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-200">Atividades</h4>
                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-emerald-600">
                            {{ number_format(\App\Models\Activity::count(), 0, ',', '.') }}
                        </p>
                        <a href="{{ route('activities.manage') }}" class="text-sm text-emerald-500 hover:underline mt-2 block transition-colors">
                            Ver Atividades →
                        </a>
                    </div>

                    {{-- Card: Inscrições --}}
                    <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow hover:shadow-xl transition-shadow duration-200">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-200">Inscrições</h4>
                            <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold text-pink-600">
                            {{ number_format(\App\Models\Enrollment::count(), 0, ',', '.') }}
                        </p>
                        <a href="{{ route('enrollments.manage') }}" class="text-sm text-pink-500 hover:underline mt-2 block transition-colors">
                            Gerir Inscrições →
                        </a>
                    </div>
                </div>

                {{-- Últimos Projetos --}}
                @php
                    $latestProjects = \App\Models\Project::latest()->take(3)->get(['id', 'title', 'description', 'created_at']);
                @endphp

                @if($latestProjects->isNotEmpty())
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Últimos Projetos Criados</h3>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($latestProjects as $project)
                                <div class="bg-white dark:bg-zinc-800 p-5 rounded-lg shadow hover:shadow-lg transition-shadow duration-200">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">
                                        {{ $project->title }}
                                    </h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                                        {{ $project->description }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-3">
                                        Criado em {{ $project->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        @elseif(auth()->user()->role === 'community')
            {{-- DASHBOARD COMUNIDADE --}}
            <div>
                <h3  class="font-semibold text-xl leading-tight" style="color: #0077b6;">Minhas Atividades</h3>

                @php
                    $enrollments = \App\Models\Enrollment::where('user_id', auth()->id())
                        ->with(['activity:id,title,start_date,end_date,project_id', 'activity.project:id,title'])
                        ->get();
                @endphp

                @forelse($enrollments as $enrollment)
                    @if($loop->first)
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @endif

                    <div class="bg-white dark:bg-zinc-800 p-5 rounded-lg shadow hover:shadow-lg transition-shadow duration-200 flex flex-col justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                {{ $enrollment->activity->title }}
                            </h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Projeto: {{ $enrollment->activity->project->title ?? 'N/A' }}
                            </p>
                            <p class="text-xs text-gray-400 mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($enrollment->activity->start_date)->format('d/m/Y') }}
                                -
                                {{ \Carbon\Carbon::parse($enrollment->activity->end_date)->format('d/m/Y') }}
                            </p>
                        </div>

                        <div class="mt-4">
                            @php
                                $statusConfig = [
                                    'approved' => ['class' => 'bg-green-100 text-green-700', 'label' => 'Aprovado'],
                                    'rejected' => ['class' => 'bg-red-100 text-red-700', 'label' => 'Rejeitado'],
                                    'pending' => ['class' => 'bg-yellow-100 text-yellow-700', 'label' => 'Pendente'],
                                ];
                                $status = $statusConfig[$enrollment->status] ?? $statusConfig['pending'];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>
                        </div>
                    </div>

                    @if($loop->last)
                        </div>
                    @endif

                @empty
                    <div class="bg-white dark:bg-zinc-800 p-8 rounded-lg shadow text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            Ainda não estás inscrito em nenhuma atividade.
                        </p>
                        <a href="{{ route('home') }}"
                           class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 font-medium">
                            Ver Atividades Disponíveis →
                        </a>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</x-app-layout>
