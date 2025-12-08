<div class="relative"> {{-- ROOT ÚNICO DO COMPONENTE LIVEWIRE --}}

    <div class="flex flex-col h-full">

        {{-- Cabeçalho --}}
        <div class="bg-white border-b border-gray-200 px-4 py-3 flex-shrink-0">
            <h4 class="font-semibold text-gray-800 flex items-center text-sm">
                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Evidências Fotográficas
            </h4>
            <p class="text-xs text-gray-500 mt-1">Envie fotos que documentem a execução desta atividade</p>
        </div>

        {{-- Área de conteúdo com scroll --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-4">

            {{-- Mensagens de Feedback --}}
            @if (session()->has('message'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-3 flex items-start animate-fade-in">
                <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm text-green-700 font-medium">{{ session('message') }}</p>
            </div>
            @endif

            @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 rounded-lg p-3 flex items-start animate-fade-in">
                <svg class="w-5 h-5 text-red-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
            </div>
            @endif

            {{-- Formulário de Upload --}}
            <form wire:submit.prevent="save" class="space-y-4">

                {{-- Área de seleção de arquivos --}}
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-400 transition-colors duration-200 bg-white cursor-pointer">
                    <input
                        type="file"
                        wire:model="photos"
                        multiple
                        accept="image/*"
                        id="photo-upload-{{ $activityId }}"
                        class="hidden" />

                    <label for="photo-upload-{{ $activityId }}" class="cursor-pointer block">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">
                            <span class="font-semibold text-indigo-600 hover:text-indigo-500">Clique para selecionar</span> ou arraste as fotos
                        </p>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF até 10MB cada</p>
                    </label>

                    <div wire:loading wire:target="photos" class="mt-3">
                        <div class="flex items-center justify-center">
                            <svg class="animate-spin h-5 w-5 text-indigo-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">Carregando fotos...</span>
                        </div>
                    </div>

                    @error('photos.*')
                    <div class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Preview das fotos selecionadas --}}
                @if (!empty($photos) && count($photos) > 0)
                <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                    <h5 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Fotos Selecionadas ({{ count($photos) }})
                    </h5>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach ($photos as $index => $photo)
                        <div class="relative group">
                            @if (is_object($photo) && method_exists($photo, 'temporaryUrl'))
                            <img
                                src="{{ $photo->temporaryUrl() }}"
                                class="w-full h-48 object-cover rounded-lg border-2 border-gray-200 shadow-sm cursor-pointer hover:border-indigo-400 transition-all"
                                alt="Preview {{ $index + 1 }}"
                                onclick="openImageModal('{{ $photo->temporaryUrl() }}')" />
                            @elseif (is_string($photo))
                            @php $tmpUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($photo); @endphp
                            <img
                                src="{{ $tmpUrl }}"
                                class="w-full h-48 object-cover rounded-lg border-2 border-gray-200 shadow-sm cursor-pointer hover:border-indigo-400 transition-all"
                                alt="Preview {{ $index + 1 }}"
                                onclick="openImageModal('{{ $tmpUrl }}')" />
                            @else
                            <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center text-sm text-gray-500 border-2 border-gray-200">
                                Sem preview
                            </div>
                            @endif

                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-200 rounded-lg flex items-center justify-center gap-2">
                                <button
                                    type="button"
                                    onclick="event.stopPropagation(); openImageModal('{{ is_object($photo) && method_exists($photo, 'temporaryUrl') ? $photo->temporaryUrl() : (is_string($photo) ? \Illuminate\Support\Facades\Storage::disk('public')->url($photo) : '') }}')"
                                    class="opacity-0 group-hover:opacity-100 bg-indigo-500 text-white rounded-full p-2 hover:bg-indigo-600 transition-all duration-200 shadow-lg"
                                    title="Visualizar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                    </svg>
                                </button>
                                <button
                                    type="button"
                                    wire:click="removePhoto({{ $index }})"
                                    class="opacity-0 group-hover:opacity-100 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 transition-all duration-200 shadow-lg"
                                    title="Remover foto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Campo de descrição --}}
                <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                    <label for="caption-{{ $activityId }}" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Descrição das Evidências (Opcional)
                    </label>
                    <textarea
                        wire:model="caption"
                        id="caption-{{ $activityId }}"
                        rows="3"
                        placeholder="Ex: Fotos da instalação dos equipamentos na escola..."
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                    @error('caption')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botões de Ação --}}
                <div class="flex items-center justify-between space-x-3">
                    <x-secondary-button
                        type="button"
                        wire:click="clearForm"
                        class="flex-1">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Limpar
                    </x-secondary-button>

                    <x-primary-button
                        type="submit"
                        class="flex-1"
                        wire:loading.attr="disabled"
                        wire:target="save">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        <span wire:loading.remove wire:target="save">Enviar Evidências</span>
                        <span wire:loading wire:target="save">Enviando...</span>
                    </x-primary-button>
                </div>
            </form>

            {{-- Lista de Evidências Já Enviadas --}}
            @if($activityId)
            @php
            $existingEvidences = \App\Models\Evidence::where('activity_id', $activityId)
            ->with(['user', 'photos'])
            ->latest()
            ->get();
            @endphp

            @if($existingEvidences->count() > 0)
            <div class="bg-white rounded-lg border border-gray-200 p-4 mt-6 shadow-sm">
                <h5 class="text-sm font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Evidências Enviadas ({{ $existingEvidences->count() }})
                </h5>

                <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                    @foreach($existingEvidences as $evidence)
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-lg p-4 border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all">

                        {{-- Informações do Usuário e Data --}}
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center text-xs text-gray-600">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center mr-2 shadow-sm">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-700">{{ $evidence->user->name ?? 'Desconhecido' }}</span>
                            </div>
                            <div class="text-xs text-gray-500 flex items-center bg-gray-100 px-2 py-1 rounded">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $evidence->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        {{-- Descrição --}}
                        @if($evidence->caption)
                        <p class="text-sm text-gray-700 mb-3 px-3 py-2 bg-white rounded-md border-l-4 border-indigo-400 shadow-sm">
                            {{ $evidence->caption }}
                        </p>
                        @endif

                        {{-- Grid de Fotos --}}
                        @if($evidence->photos && $evidence->photos->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($evidence->photos as $photo)
                            @php
                            $url = $photo->url; // Usa o accessor
                            @endphp

                            <div class="group relative block">
                                @if($url)
                                <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer"
                                    onclick="openImageModal('{{ $url }}')">
                                    <img
                                        src="{{ $url }}"
                                        class="w-full h-40 md:h-48 object-cover transform group-hover:scale-110 transition-transform duration-300"
                                        alt="Evidência"
                                        loading="lazy" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                        <div class="bg-white/90 backdrop-blur-sm rounded-full p-3 transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="w-full h-40 md:h-48 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-xs text-gray-500">
                                    <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Ficheiro não encontrado</span>
                                    <span class="text-xs text-gray-400 mt-1">{{ basename($photo->filename) }}</span>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="bg-gray-50 rounded p-3 text-sm text-gray-500 text-center">
                            Nenhuma foto nesta evidência
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="bg-white rounded-lg border-2 border-dashed border-gray-300 p-8 mt-6 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-sm text-gray-600 font-medium">Nenhuma evidência enviada ainda</p>
                <p class="text-xs text-gray-500 mt-1">Seja o primeiro a documentar esta atividade!</p>
            </div>
            @endif
            @endif
        </div>
    </div>

    {{-- Modal de Zoom de Imagem --}}
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
        <div class="relative max-w-7xl max-h-full" onclick="event.stopPropagation()">
            {{-- Botão de fechar --}}
            <button
                onclick="closeImageModal()"
                class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors bg-black/50 rounded-full p-2 backdrop-blur-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Imagem ampliada --}}
            <img
                id="modalImage"
                src=""
                class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl"
                alt="Imagem ampliada" />

            {{-- Controles de zoom --}}
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 bg-black/70 backdrop-blur-sm rounded-full p-2">
                <button onclick="zoomOut()" class="text-white hover:text-gray-300 transition-colors p-2 hover:bg-white/10 rounded-full" title="Diminuir zoom">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" />
                    </svg>
                </button>
                <button onclick="resetZoom()" class="text-white hover:text-gray-300 transition-colors p-2 hover:bg-white/10 rounded-full" title="Reset zoom">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
                <button onclick="zoomIn()" class="text-white hover:text-gray-300 transition-colors p-2 hover:bg-white/10 rounded-full" title="Aumentar zoom">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </button>
            </div>
        </div>

        <style>
            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in {
                animation: fade-in 0.3s ease-out;
            }

            #modalImage {
                transition: transform 0.3s ease;
            }

            #imageModal {
                animation: fade-in 0.2s ease-out;
            }
        </style>


        <script>
            let currentZoom = 1;

            function openImageModal(imageUrl) {
                const modal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');
                modalImage.src = imageUrl;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                currentZoom = 1;
                modalImage.style.transform = `scale(${currentZoom})`;
                document.body.style.overflow = 'hidden';
            }

            function closeImageModal() {
                const modal = document.getElementById('imageModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
                currentZoom = 1;
            }

            function zoomIn() {
                event.stopPropagation();
                currentZoom = Math.min(currentZoom + 0.25, 3);
                document.getElementById('modalImage').style.transform = `scale(${currentZoom})`;
            }

            function zoomOut() {
                event.stopPropagation();
                currentZoom = Math.max(currentZoom - 0.25, 0.5);
                document.getElementById('modalImage').style.transform = `scale(${currentZoom})`;
            }

            function resetZoom() {
                event.stopPropagation();
                currentZoom = 1;
                document.getElementById('modalImage').style.transform = `scale(${currentZoom})`;
            }

            // Fechar modal com tecla ESC
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeImageModal();
                }
            });
        </script>
    </div>

</div>
