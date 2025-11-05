<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-100">
            {{ __('Painel Principal') }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- MENSAGEM DE BOAS-VINDAS --}}
        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 text-white rounded-xl p-6 shadow-lg">
            <h1 class="text-2xl font-semibold">
                Olá, {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-sm opacity-90 mt-1">
                Bem-vindo(a) ao Sistema de Extensão Universitária.
            </p>
        </div>

        {{-- PAINEL DIFERENCIADO POR FUNÇÃO --}}
        @if(in_array(auth()->user()->role, ['admin', 'coordinator']))
            {{-- DASHBOARD ADMIN/COORDENADOR --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Visão Geral</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    {{-- Projetos --}}
                    <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow hover:shadow-xl transition">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-200">Projetos</h4>
                            <x-heroicon-o-briefcase class="w-6 h-6 text-indigo-500" />
                        </div>
                        <p class="text-3xl font-bold text-indigo-600">
                            {{ \App\Models\Project::count() }}
                        </p>
                        <a href="{{ route('projects.manage') }}" class="text-sm text-indigo-500 hover:underline mt-2 block">
                            Gerir Projetos →
                        </a>
                    </div>

                    {{-- Atividades --}}
                    <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow hover:shadow-xl transition">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-200">Atividades</h4>
                            <x-heroicon-o-calendar class="w-6 h-6 text-emerald-500" />
                        </div>
                        <p class="text-3xl font-bold text-emerald-600">
                            {{ \App\Models\Activity::count() }}
                        </p>
                        <a href="{{ route('activities.manage') }}" class="text-sm text-emerald-500 hover:underline mt-2 block">
                            Ver Atividades →
                        </a>
                    </div>

                    {{-- Inscrições --}}
                    <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow hover:shadow-xl transition">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-200">Inscrições</h4>
                            <x-heroicon-o-users class="w-6 h-6 text-pink-500" />
                        </div>
                        <p class="text-3xl font-bold text-pink-600">
                            {{ \App\Models\Enrollment::count() }}
                        </p>
                        <a href="{{ route('enrollments.manage', ['activity' => 1]) }}" class="text-sm text-pink-500 hover:underline mt-2 block">
                            Gerir Inscrições →
                        </a>
                    </div>
                </div>

                {{-- Últimos Projetos --}}
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Últimos Projetos Criados</h3>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach(\App\Models\Project::latest()->take(3)->get() as $project)
                            <div class="bg-white dark:bg-zinc-800 p-5 rounded-lg shadow">
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $project->title }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($project->description, 80) }}</p>
                                <p class="text-xs text-gray-400 mt-2">Criado em {{ $project->created_at->format('d/m/Y') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        @elseif(auth()->user()->role === 'community')
            {{-- DASHBOARD COMUNIDADE --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Minhas Atividades</h3>

                @php
                    $enrollments = \App\Models\Enrollment::where('user_id', auth()->id())->with('activity.project')->get();
                @endphp

                @if($enrollments->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300">Ainda não estás inscrito em nenhuma atividade.</p>
                    <a href="{{ route('home') }}" class="mt-3 inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                        Ver Atividades Disponíveis →
                    </a>
                @else
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($enrollments as $enroll)
                            <div class="bg-white dark:bg-zinc-800 p-5 rounded-lg shadow flex flex-col justify-between">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $enroll->activity->title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Projeto: {{ $enroll->activity->project->title ?? 'N/A' }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-2">
                                        {{ \Carbon\Carbon::parse($enroll->activity->start_date)->format('d/m/Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($enroll->activity->end_date)->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div class="mt-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($enroll->status === 'approved') bg-green-100 text-green-700
                                        @elseif($enroll->status === 'rejected') bg-red-100 text-red-700
                                        @else bg-yellow-100 text-yellow-700 @endif">
                                        {{ ucfirst($enroll->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
