<div class="max-w-5xl mx-auto bg-gradient-to-br from-slate-50 to-slate-100 shadow-2xl rounded-3xl overflow-hidden border border-slate-200">

    <!-- HEADER com animação -->
    <div class="relative px-8 py-6 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-1 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        {{ $activity->title }}
                    </h2>
                    <p class="text-sm opacity-90 flex items-center gap-2">
                        <span class="inline-block w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        {{ $messages->count() }} mensagens ativas
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-xs opacity-75">Online agora</div>
                    <div class="flex -space-x-2 mt-1">
                        <!-- Avatares de usuários online -->
                        <div class="w-8 h-8 rounded-full bg-white/20 border-2 border-white flex items-center justify-center text-xs">3+</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Decoração animada -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
    </div>

    <!-- MENSAGENS com scroll suave -->
    <div id="chatBox" class="h-[550px] overflow-y-auto p-8 space-y-6 bg-gradient-to-b from-slate-50 to-white custom-scrollbar">

        @forelse ($messages as $msg)
        <div class="animate-fadeIn @if($msg->user_id === Auth::id()) flex justify-end @else flex justify-start @endif">

            <div class="flex gap-3 max-w-[80%] @if($msg->user_id === Auth::id()) flex-row-reverse @endif">

                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br @if($msg->user_id === Auth::id()) from-indigo-500 to-purple-500 @else from-emerald-500 to-teal-500 @endif flex items-center justify-center text-white font-bold shadow-lg">
                        {{ substr($msg->user->name, 0, 1) }}
                    </div>
                </div>

                <!-- Conteúdo da mensagem -->
                <div class="flex-1">
                    <div class="group relative">

                        <div class="px-5 py-4 rounded-3xl shadow-md transition-all duration-200 hover:shadow-xl
                                @if($msg->user_id === Auth::id())
                                    bg-gradient-to-br from-indigo-600 to-purple-600 text-white rounded-tr-sm
                                @else
                                    bg-white text-gray-800 border border-slate-200 rounded-tl-sm
                                @endif">

                            <div class="text-xs font-bold mb-2 @if($msg->user_id === Auth::id()) opacity-90 @else text-indigo-600 @endif">
                                {{ $msg->user->name }}
                            </div>

                            <div class="text-[15px] leading-relaxed break-words">
                                {{ $msg->content }}
                            </div>

                            <div class="flex items-center gap-2 mt-3 text-[11px] @if($msg->user_id === Auth::id()) opacity-70 @else text-slate-500 @endif">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $msg->created_at->format('d/m H:i') }}
                            </div>
                        </div>

                        <!-- Ações hover -->
                        <div class="absolute -bottom-8 @if($msg->user_id === Auth::id()) right-0 @else left-0 @endif opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <button wire:click="replyTo({{ $msg->id }})"
                                class="flex items-center gap-1 text-xs px-3 py-1.5 bg-white border border-slate-300 rounded-full text-slate-700 hover:bg-slate-50 shadow-sm transition-all hover:scale-105">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                </svg>
                                Responder
                            </button>
                        </div>
                    </div>

                    <!-- REPLIES com estilo melhorado -->
                    @if($msg->replies->count() > 0)
                    <div class="mt-6 space-y-3 pl-4 border-l-2 @if($msg->user_id === Auth::id()) border-indigo-300 @else border-emerald-300 @endif">
                        @foreach ($msg->replies as $reply)
                        <div class="animate-slideIn">
                            <div class="flex gap-2 items-start">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-slate-400 to-slate-500 flex items-center justify-center text-white text-xs font-bold shadow">
                                    {{ substr($reply->user->name, 0, 1) }}
                                </div>

                                <div class="flex-1">
                                    <div class="px-4 py-3 bg-gradient-to-br from-slate-100 to-slate-200 text-gray-900 rounded-2xl rounded-tl-sm border border-slate-300 shadow-sm">

                                        <div class="text-xs font-bold mb-1 text-slate-700">
                                            {{ $reply->user->name }}
                                        </div>

                                        <div class="text-sm leading-relaxed">
                                            {{ $reply->content }}
                                        </div>

                                        <div class="flex items-center gap-1 mt-2 text-[10px] text-slate-500">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $reply->created_at->format('d/m H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @empty

        <div class="flex flex-col items-center justify-center h-full text-center py-20">
            <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <p class="text-slate-500 text-lg font-medium mb-2">
                Nenhuma mensagem ainda
            </p>
            <p class="text-slate-400 text-sm">
                Seja o primeiro a iniciar a conversa! 💬
            </p>
        </div>

        @endforelse

    </div>

    <!-- CAMPO DE ENVIO melhorado -->
    <div class="border-t border-slate-200 bg-white p-6">

        @if($parentMessageId)
        <div class="mb-4 p-3 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center justify-between animate-slideDown">
            <div class="flex items-center gap-2 text-sm">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                </svg>
                <span class="text-indigo-700 font-semibold">Respondendo uma mensagem</span>
            </div>
            <button wire:click="clearReply"
                class="text-red-600 hover:text-red-700 hover:bg-red-50 p-1 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        @endif

        <form wire:submit.prevent="sendMessage" class="flex gap-3">
            <div class="flex-1 relative">
                <input type="text"
                    wire:model="newMessage"
                    placeholder="Digite sua mensagem aqui…"
                    class="w-full border-slate-300 rounded-2xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 pl-5 pr-12 py-4 text-[15px] transition-all">

                <!-- Emoji button (decorativo) -->
                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </button>
            </div>

            <button type="submit"
                class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 font-semibold flex items-center gap-2">
                <span>Enviar</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
            </button>
        </form>

        <div class="mt-3 text-xs text-slate-400 text-center">
            Pressione Enter para enviar • Shift+Enter para nova linha
        </div>
    </div>
    <style>
    /* Scrollbar customizada */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #818cf8, #a855f7);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #6366f1, #9333ea);
    }

    /* Animações */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

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

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }

    .animate-slideIn {
        animation: slideIn 0.3s ease-out;
    }

    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }
</style>
</div>



<script>
    document.addEventListener("livewire:init", () => {
        Livewire.on("message-sent", () => {
            const chat = document.getElementById("chatBox");
            setTimeout(() => {
                chat.scrollTo({
                    top: chat.scrollHeight,
                    behavior: 'smooth'
                });
            }, 100);
        });

        // Auto-resize textarea on enter (opcional - requer textarea em vez de input)
        const input = document.querySelector('input[wire\\:model="newMessage"]');
        if (input) {
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    input.closest('form').dispatchEvent(new Event('submit', {
                        bubbles: true
                    }));
                }
            });
        }
    });
</script>
