<div class="p-8 bg-white rounded-2xl shadow-lg">
    <!-- Cabeçalho -->
    <div class="mb-6">
        <h3 class="font-bold text-2xl text-gray-800">Relatórios</h3>
        <p class="text-gray-500 text-sm mt-1">Gere e baixe relatórios personalizados do sistema</p>
    </div>

    <div class="space-y-6">
        <!-- Formulário de Geração -->
        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
            <h4 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Gerar Novo Relatório
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Tipo de Relatório</label>
                    <select wire:model="reportType" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <option value="enrollments">📋 Inscrições</option>
                        <option value="activities">🎯 Atividades</option>
                        <option value="projects">📊 Projetos</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Formato</label>
                    <select wire:model="format" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <option value="csv">📄 CSV</option>
                        <option value="pdf">📕 PDF</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Data Inicial</label>
                    <input type="date" wire:model="from" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Data Final</label>
                    <input type="date" wire:model="to" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
                </div>

                <div class="flex items-end">
                    <button wire:click="generate" class="w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-colors duration-200 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Gerar
                    </button>
                </div>
            </div>

            @if(session()->has('message'))
                <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm text-green-700 font-medium">{{ session('message') }}</span>
                </div>
            @endif
        </div>

        <!-- Lista de Relatórios Recentes -->
        <div>
            <h4 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Relatórios Recentes
            </h4>

            <div class="bg-gray-50 rounded-xl border border-gray-100 overflow-hidden">
                @if($recent->isEmpty())
                    <div class="p-8 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500 text-sm">Nenhum relatório gerado ainda.</p>
                        <p class="text-gray-400 text-xs mt-1">Comece gerando seu primeiro relatório acima.</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($recent as $r)
                            <li class="p-4 hover:bg-gray-100 transition-colors duration-150">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3 flex-1">
                                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                            @if($r->format === 'pdf')
                                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800 text-sm">
                                                {{ ucfirst($r->type) }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-0.5">
                                                {{ strtoupper($r->format) }} • {{ \Carbon\Carbon::parse($r->created_at)->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                    <button wire:click="downloadLog({{ $r->id }})" class="px-4 py-2 text-indigo-600 hover:bg-indigo-50 rounded-lg text-sm font-medium transition-colors duration-150 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Download
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
