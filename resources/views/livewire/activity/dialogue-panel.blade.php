<div class="bg-zinc-900 rounded-2xl shadow-lg border border-zinc-700 overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
        <h4 class="font-bold text-lg text-white">Conversa da Atividade</h4>
    </div>

    <!-- Messages Container -->
    <div class="max-h-96 overflow-y-auto p-4 space-y-3 bg-zinc-800" style="scroll-behavior: smooth;">
        @foreach($messages->take(-5) as $msg)
            <div class="flex gap-2">
                <!-- Avatar -->
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0 mt-1">
                    {{ strtoupper(substr($msg->user->name ?? 'U', 0, 1)) }}
                </div>

                <div class="flex-1">
                    <!-- Main Message Bubble -->
                    <div class="bg-emerald-600 rounded-lg rounded-tl-none shadow-sm max-w-[85%] p-3">
                        <!-- User Info -->
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-semibold text-white text-sm">
                                {{ $msg->user->name ?? 'Usuário' }}
                            </span>
                        </div>

                        <!-- Message Content -->
                        <p class="text-sm text-white leading-relaxed mb-1">
                            {{ $msg->content }}
                        </p>

                        <!-- Time and Reply Button -->
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-xs text-emerald-100">
                                {{ $msg->created_at->diffForHumans() }}
                            </span>
                            <button
                                wire:click="setReplyTo({{ $msg->id }})"
                                class="text-xs font-medium text-white hover:text-emerald-100 transition-colors">
                                💬 Responder
                            </button>
                        </div>
                    </div>

                    <!-- Replies Section -->
                    @if($msg->replies->count())
                        <div class="mt-2 ml-4 space-y-2">
                            @foreach($msg->replies as $rep)
                                <div class="flex gap-2">
                                    <!-- Reply Avatar -->
                                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                        {{ strtoupper(substr($rep->user->name ?? 'U', 0, 1)) }}
                                    </div>

                                    <!-- Reply Bubble -->
                                    <div class="bg-teal-700 rounded-lg rounded-tl-none p-2.5 max-w-[80%] shadow-sm border border-teal-600">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs font-semibold text-teal-200">
                                                {{ $rep->user->name ?? 'Usuário' }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-100">
                                            {{ $rep->content }}
                                        </p>
                                        <span class="text-xs text-teal-300 mt-1 block">
                                            {{ $rep->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Message Input Form -->
    <div class="bg-zinc-900 p-4 border-t border-zinc-700">
        <form wire:submit.prevent="sendMessage" class="space-y-3">
            <!-- Reply Indicator -->
            @if($replyTo)
                <div class="flex items-center justify-between bg-emerald-950/30 px-4 py-2.5 rounded-lg border-l-4 border-emerald-500">
                    <span class="text-sm text-emerald-300 font-medium">
                        💬 Respondendo à mensagem #{{ $replyTo }}
                    </span>
                    <button
                        type="button"
                        wire:click="clearReply"
                        class="text-sm text-red-400 hover:text-red-300 font-medium transition-colors">
                        ✕ Cancelar
                    </button>
                </div>
            @endif

            <!-- Textarea and Send Button -->
            <div class="flex gap-2 items-end">
                <textarea
                    wire:model.defer="newMessage"
                    rows="2"
                    class="flex-1 p-3 rounded-2xl border-2 border-zinc-600 resize-none bg-zinc-800 text-gray-100 placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-900/50 transition-all outline-none"
                    placeholder="Digite uma mensagem..."></textarea>

                <button
                    type="submit"
                    class="px-5 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-medium rounded-2xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
