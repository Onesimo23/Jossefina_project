<div class="bg-gray-50 dark:bg-zinc-900 min-h-screen">

    {{-- Notification Toast --}}
    @if (session()->has('message'))
    <div x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 5000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-x-full"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed top-24 right-4 z-50 max-w-md">
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-2xl shadow-2xl border-2 border-white/30 backdrop-blur-sm p-4">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
        </div>
    </div>
    @endif

    {{-- Hero Section com Animações --}}
    <section class="relative bg-gradient-to-br from-blue-700 via-indigo-800 to-purple-900 dark:from-slate-900 dark:via-purple-900 dark:to-slate-900 pt-20 pb-32 overflow-hidden">
        {{-- Animated Background Blobs --}}
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-white rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-0 left-1/3 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-white to-yellow-300 mb-6 drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)] animate-fade-in-down">
                    🌟 Extensão Universitária
                </h1>
                <p class="text-xl md:text-3xl text-white dark:text-white max-w-4xl mx-auto mb-8 leading-relaxed animate-fade-in-up">
                    Conectando <span class="font-bold text-yellow-300 drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)]">conhecimento acadêmico</span> com
                    <span class="font-bold text-yellow-300 drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)]">transformação social</span>
                </p>
                <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto mb-12 animate-fade-in-up animation-delay-200">
                    Uma plataforma que integra a comunidade com a academia através de projetos, atividades e experiências que transformam vidas
                </p>

                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16 animate-fade-in-up animation-delay-400">
                    @auth
                    @if(auth()->user()->role === 'community')
                    <a href="#atividades" class="inline-flex items-center justify-center px-8 py-4 bg-white text-indigo-600 font-bold rounded-full shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300">
                        <span>Explorar Atividades</span>
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    @endif
                    @else
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white font-bold rounded-full shadow-[0_4px_14px_0_rgba(255,186,0,0.4)] hover:shadow-[0_6px_20px_0_rgba(255,186,0,0.6)] transition-all duration-300">
                        <span>Junte-se a Nós</span>
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-full hover:bg-white hover:text-indigo-600 transition-all duration-300">
                        Entrar
                    </a>
                    @endauth
                </div>

                {{-- Stats Counter --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                    <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-6 transform hover:scale-105 transition-all duration-300 border border-white/20">
                        <div class="text-5xl font-extrabold text-yellow-300 drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)] mb-2" x-data="{ count: 0 }" x-init="setInterval(() => { if(count < {{ $activities->count() }}) count++ }, 30)">
                            <span x-text="count"></span>
                        </div>
                        <div class="text-white font-medium text-sm">Atividades Disponíveis</div>
                    </div>
                    @auth
                    @if(auth()->user()->role === 'community')
                    <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-6 transform hover:scale-105 transition-all duration-300 border border-white/20">
                        <div class="text-5xl font-extrabold text-yellow-300 mb-2">{{ count($userEnrollments) }}</div>
                        <div class="text-white/90 font-medium text-sm">Suas Inscrições</div>
                    </div>
                    @endif
                    @endauth
                    <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-6 transform hover:scale-105 transition-all duration-300 border border-white/20">
                        <div class="text-5xl font-extrabold text-white mb-2" x-data="{ count: 0 }" x-init="setInterval(() => { if(count < 1250) count += 25 }, 50)">
                            <span x-text="count"></span>+
                        </div>
                        <div class="text-white/90 font-medium text-sm">Participantes Ativos</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-6 transform hover:scale-105 transition-all duration-300 border border-white/20">
                        <div class="text-5xl font-extrabold text-white mb-2" x-data="{ count: 0 }" x-init="setInterval(() => { if(count < 23) count++ }, 80)">
                            <span x-text="count"></span>
                        </div>
                        <div class="text-white/90 font-medium text-sm">Comunidades Atendidas</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Wave Divider --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 0L60 10C120 20 240 40 360 46.7C480 53 600 47 720 43.3C840 40 960 40 1080 46.7C1200 53 1320 67 1380 73.3L1440 80V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V0Z"
                    fill="currentColor"
                    class="text-gray-50 dark:text-zinc-900" />
            </svg>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="py-20 bg-white dark:bg-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    Por que Participar?
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Descubra os benefícios de fazer parte da extensão universitária
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Feature Card 1 --}}
                <div class="group relative bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-zinc-800 dark:to-zinc-700 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-blue-100 dark:border-zinc-600">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Aprendizado Prático</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Aplique conhecimentos teóricos em situações reais e desenvolva habilidades práticas valorizadas pelo mercado
                    </p>
                </div>

                {{-- Feature Card 2 --}}
                <div class="group relative bg-gradient-to-br from-purple-50 to-pink-50 dark:from-zinc-800 dark:to-zinc-700 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-purple-100 dark:border-zinc-600">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Impacto Social</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Contribua diretamente para o desenvolvimento da comunidade e faça a diferença na vida das pessoas
                    </p>
                </div>

                {{-- Feature Card 3 --}}
                <div class="group relative bg-gradient-to-br from-green-50 to-emerald-50 dark:from-zinc-800 dark:to-zinc-700 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-green-100 dark:border-zinc-600">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Networking</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Conecte-se com professores, profissionais e colegas, expandindo sua rede de contatos profissionais
                    </p>
                </div>

                {{-- Feature Card 4 --}}
                <div class="group relative bg-gradient-to-br from-orange-50 to-red-50 dark:from-zinc-800 dark:to-zinc-700 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-orange-100 dark:border-zinc-600">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Certificação</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Receba certificados reconhecidos que enriquecem seu currículo e comprovam suas experiências
                    </p>
                </div>

                {{-- Feature Card 5 --}}
                <div class="group relative bg-gradient-to-br from-yellow-50 to-amber-50 dark:from-zinc-800 dark:to-zinc-700 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-yellow-100 dark:border-zinc-600">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Inovação</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Participe de projetos inovadores que buscam soluções criativas para desafios contemporâneos
                    </p>
                </div>

                {{-- Feature Card 6 --}}
                <div class="group relative bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-zinc-800 dark:to-zinc-700 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-teal-100 dark:border-zinc-600">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Responsabilidade Social</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Desenvolva consciência social e contribua para construção de uma sociedade mais justa e equitativa
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Search and Filter Section --}}
    <section id="atividades" class="py-16 bg-gray-50 dark:bg-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    Atividades Disponíveis
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">
                    Encontre a atividade perfeita para você
                </p>
            </div>

            {{-- Search Bar --}}
            <div class="max-w-4xl mx-auto mb-12">
                <div class="bg-white dark:bg-zinc-700 rounded-3xl shadow-2xl p-6 border-2 border-gray-100 dark:border-zinc-600">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative">
                            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Buscar por título ou descrição..."
                                class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-gray-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white focus:ring-4 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300 placeholder-gray-400 text-lg">
                        </div>

                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            <select wire:model.live="projectFilter"
                                class="pl-12 pr-8 py-4 rounded-2xl border-2 border-gray-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white focus:ring-4 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300 cursor-pointer appearance-none text-lg min-w-[250px]">
                                <option value="">Todos os Projetos</option>
                                @foreach(\App\Models\Project::all() as $project)
                                <option value="{{ $project->id }}">{{ $project->title }}</option>
                                @endforeach
                            </select>
                            <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activities Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($activities as $activity)
                <div class="group relative bg-e dark:bg-slate-800 rounded-3xl shadow-xl hover:shadow-2xl overflow-hidden border-2 border-indigo-100 dark:border-indigo-900 cursor-pointer transform hover:-translate-y-3 transition-all duration-500"
                    wire:click="openActivityModal({{ $activity->id }})">

                    {{-- Card Header with Gradient --}}
                    <div class="h-56 bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 relative overflow-hidden">
                        {{-- Overlay Pattern --}}
                        <div class="absolute inset-0 opacity-20">
                            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                        </div>

                        {{-- Hover Overlay --}}
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-all duration-300"></div>

                        {{-- Project Badge --}}
                        <div class="absolute top-4 left-4">
                            <span class="inline-block bg-white/95 backdrop-blur-sm text-indigo-700 text-xs font-bold px-4 py-2 rounded-full shadow-xl border border-indigo-100">
                                {{ $activity->project->title ?? 'Projeto Geral' }}
                            </span>
                        </div>

                        {{-- Enrollment Badge --}}
                        @auth
                        @if(auth()->user()->role === 'community' && in_array($activity->id, $userEnrollments))
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center gap-1 bg-green-500/95 backdrop-blur-sm text-white text-xs font-bold px-3 py-2 rounded-full shadow-xl">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Inscrito
                            </span>
                        </div>
                        @endif
                        @endauth

                        {{-- Decorative Elements --}}
                        <div class="absolute bottom-0 left-0 right-0">
                            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                                <path d="M0 0L60 10C120 20 240 40 360 46.7C480 53 600 47 720 43.3C840 40 960 40 1080 46.7C1200 53 1320 67 1380 73.3L1440 80V120H0V0Z"
                                    fill="white"
                                    class="dark:fill-zinc-700" />
                            </svg>
                        </div>
                    </div>

                    {{-- Card Content --}}
                    <div class="p-6 space-y-4">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300 line-clamp-2 min-h-[3.5rem]">
                            {{ $activity->title }}
                        </h3>

                        {{-- Info Grid --}}
                        <div class="space-y-3">
                            {{-- Location --}}
                            <div class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                                <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ $activity->location ?? 'Local a definir' }}</span>
                            </div>

                            {{-- Date --}}
                            <div class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                                <div class="flex-shrink-0 w-10 h-10 bg-pink-100 dark:bg-pink-900/30 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($activity->start_date)->format('d/m/Y') }}</span>
                            </div>

                            {{-- Status --}}
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium text-green-600 dark:text-green-400">Inscrições Abertas</span>
                            </div>
                        </div>

                        {{-- Action Button --}}
                        <div class="pt-4">
                            @if(!Auth::check())
                            <a href="{{ route('login') }}" onclick="event.stopPropagation()"
                                class="inline-flex items-center justify-center w-full py-3 px-6 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group/btn">
                                <span>Entrar para Inscrever-se</span>
                                <svg class="ml-2 w-5 h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                            @elseif(auth()->user()->role === 'community')
                            @if(in_array($activity->id, $userEnrollments))
                            <button wire:click.stop="toggleEnrollment({{ $activity->id }})"
                                class="inline-flex items-center justify-center w-full py-3 px-6 bg-red-600 hover:bg-red-700 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                                <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar Inscrição
                            </button>
                            @else
                            <button wire:click.stop="toggleEnrollment({{ $activity->id }})"
                                class="inline-flex items-center justify-center w-full py-3 px-6 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group/btn">
                                <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Inscrever-se Agora
                            </button>
                            @endif
                            @endif
                        </div>
                    </div>

                    {{-- Hover Effect Overlay --}}
                    <div class="absolute inset-0 border-4 border-transparent group-hover:border-indigo-500 dark:group-hover:border-indigo-400 rounded-3xl transition-all duration-300 pointer-events-none"></div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="text-center py-20 bg-white dark:bg-zinc-700 rounded-3xl shadow-xl border-2 border-dashed border-gray-300 dark:border-zinc-600">
                        <svg class="mx-auto w-24 h-24 text-gray-400 dark:text-gray-500 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-3xl font-bold text-gray-400 dark:text-gray-500 mb-3">Nenhuma atividade encontrada</h3>
                        <p class="text-lg text-gray-500 dark:text-gray-400 mb-6">Tente ajustar seus filtros de busca</p>
                        <button wire:click="$set('search', '')" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all duration-300">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Limpar Filtros
                        </button>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Testimonials Section --}}
    <section class="py-20 bg-white dark:bg-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    O Que Dizem Nossos Participantes
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">
                    Experiências reais de quem faz parte da extensão universitária
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Testimonial 1 --}}
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-zinc-800 dark:to-zinc-700 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-blue-100 dark:border-zinc-600">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            @endfor
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed italic">
                        "A extensão universitária me proporcionou uma experiência única. Pude aplicar meus conhecimentos e ver o impacto real na comunidade. Foi transformador!"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            MA
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">Maria Almeida</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Estudante de Informática</p>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 2 --}}
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-zinc-800 dark:to-zinc-700 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-purple-100 dark:border-zinc-600">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            @endfor
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed italic">
                        "Participar das atividades de extensão ampliou minha visão profissional e me conectou com pessoas incríveis. Recomendo a todos!"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            JS
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">João Silva</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Membro da Comunidade</p>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 3 --}}
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-zinc-800 dark:to-zinc-700 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-green-100 dark:border-zinc-600">
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            @endfor
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 mb-6 leading-relaxed italic">
                        "Os projetos de extensão me deram ferramentas práticas e me ajudaram a desenvolver habilidades essenciais para minha carreira."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            AC
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">Ana Costa</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Coordenadora de Projeto</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 dark:from-zinc-800 dark:via-zinc-700 dark:to-zinc-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-full h-full" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;100&quot; height=&quot;100&quot; viewBox=&quot;0 0 100 100&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cpath d=&quot;M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z&quot; fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.5&quot; fill-rule=&quot;evenodd&quot;/%3E%3C/svg%3E');"></div>
        </div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-6xl font-extrabold text-white mb-6">
                Pronto para Fazer a Diferença?
            </h2>
            <p class="text-xl md:text-2xl text-white/90 mb-12 leading-relaxed">
                Junte-se a nós e seja parte da transformação social através da extensão universitária
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-10 py-5 bg-white text-indigo-600 font-bold rounded-full shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300 text-lg">
                    <span>Criar Conta Grátis</span>
                    <svg class="ml-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                @else
                <a href="#atividades" class="inline-flex items-center justify-center px-10 py-5 bg-white text-indigo-600 font-bold rounded-full shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300 text-lg">
                    <span>Ver Todas as Atividades</span>
                    <svg class="ml-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
                @endguest
            </div>
        </div>
    </section>

    {{-- Activity Detail Modal --}}
    <div x-data="{ show: @entangle('showActivityModal').live }"
        x-on:close.stop="show = false"
        x-on:keydown.escape.window="show = false"
        x-show="show"
        class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
        style="display: none;">

        {{-- Backdrop --}}
        <div x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/80 backdrop-blur-sm"
            x-on:click="show = false"></div>

        {{-- Modal Content --}}
        <div x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="relative max-w-4xl mx-auto my-8">

            @if ($selectedActivity)
            <div class="bg-white dark:bg-zinc-800 rounded-3xl shadow-2xl overflow-hidden border-2 border-gray-100 dark:border-zinc-700">

                {{-- Header --}}
                <div class="h-64 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 relative overflow-hidden">
                    <button wire:click="closeModal"
                        class="absolute top-4 right-4 w-12 h-12 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    {{-- Título da atividade --}}
                    <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/70 to-transparent">
                        <h3 class="text-3xl font-bold text-red mb-2">
                            {{ $selectedActivity->title }}
                        </h3>
                        <p class="text-white/80">
                            {{ $selectedActivity->project->title ?? 'Projeto associado' }}
                        </p>
                    </div>
                </div>

                {{-- Corpo --}}
                <div class="p-6 space-y-6">
                    {{-- Descrição --}}
                    <div>
                        <h4 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent dark:from-indigo-400 dark:to-purple-400 mb-4">
                            Descrição
                        </h4>
                        <p class="text-blue-600 dark:text-red-300 leading-relaxed">
                            {{ $selectedActivity->description ?? 'Sem descrição disponível.' }}
                        </p>
                    </div>

                    {{-- Detalhes --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-zinc-700 rounded-2xl p-4">
                            <h5 class="font-bold text-gray-800 dark:text-gray-100 mb-1">📍 Localização</h5>
                            <p class="text-gray-600 dark:text-gray-300">{{ $selectedActivity->location ?? 'Não definida' }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-zinc-700 rounded-2xl p-4">
                            <h5 class="font-bold text-gray-800 dark:text-gray-100 mb-1">📅 Data</h5>
                            <p class="text-gray-600 dark:text-gray-300">
                                {{ \Carbon\Carbon::parse($selectedActivity->start_date)->format('d/m/Y') }}
                                @if($selectedActivity->end_date)
                                – {{ \Carbon\Carbon::parse($selectedActivity->end_date)->format('d/m/Y') }}
                                @endif
                            </p>
                        </div>

                        <div class="bg-gray-50 dark:bg-zinc-700 rounded-2xl p-4">
                            <h5 class="font-bold text-gray-800 dark:text-gray-100 mb-1">👥 Vagas</h5>
                            <p class="text-gray-600 dark:text-gray-300">{{ $selectedActivity->required_slots ?? 'Ilimitadas' }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-zinc-700 rounded-2xl p-4">
                            <h5 class="font-bold text-gray-800 dark:text-gray-100 mb-1">🎓 Status</h5>
                            <p class="text-gray-600 dark:text-gray-300 capitalize">
                                {{ $selectedActivity->status }}
                            </p>
                        </div>
                    </div>

                    {{-- Botões --}}
                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                        @if(in_array($selectedActivity->id, $userEnrollments))
                        <button wire:click="unenroll({{ $selectedActivity->id }})"
                            class="w-full sm:w-auto px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-2xl shadow-lg transition-all duration-300">
                            Cancelar Inscrição
                        </button>
                        @else
                        <button wire:click="enroll({{ $selectedActivity->id }})"
                            class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-2xl shadow-lg transition-all duration-300">
                            Inscrever-se Agora
                        </button>
                        @endif
                        @else
                        <a href="{{ route('login') }}"
                            class="w-full sm:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg transition-all duration-300">
                            Fazer Login para Inscrever-se
                        </a>
                        @endauth

                        <button wire:click="closeModal"
                            class="w-full sm:w-auto px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-2xl transition-all duration-300">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-6 max-w-4xl mx-auto">
                <livewire:activity.dialogue-panel :activity-id="$selectedActivity->id" />
            </div>
        </div>
    </div>
    @endif

    <style>
        .bg-gradient {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .animate-fade-in-down {
            animation: fadeInDown 1s ease-out;
        }

        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .drop-shadow-custom {
            filter: drop-shadow(0 2px 2px rgba(0, 0, 0, 0.5));
        }
    </style>
</div>
