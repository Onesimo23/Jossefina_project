<div class="bg-white dark:bg-zinc-800 rounded-2xl p-4 border">
    <h4 class="font-bold text-lg mb-3">Conversa da Atividade</h4>

    <div class="max-h-72 overflow-y-auto space-y-3 mb-4">
        @foreach($messages as $msg)
            <div class="p-3 rounded-xl border">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-semibold">{{ $msg->user->name ?? 'Usuário' }} <span class="text-xs text-gray-400">{{ $msg->created_at->diffForHumans() }}</span></div>
                        <div class="text-sm mt-1">{{ $msg->content }}</div>
                        <div class="mt-2">
                            <button wire:click="setReplyTo({{ $msg->id }})" class="text-xs text-indigo-600">Responder</button>
                        </div>
                    </div>
                </div>

                @if($msg->replies->count())
                    <div class="mt-3 ml-4 space-y-2">
                        @foreach($msg->replies as $rep)
                            <div class="p-2 rounded-lg bg-gray-50 dark:bg-zinc-700 border">
                                <div class="text-xs text-gray-500">{{ $rep->user->name ?? 'Usuário' }} • {{ $rep->created_at->diffForHumans() }}</div>
                                <div class="text-sm mt-1">{{ $rep->content }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div>
        @if($replyTo)
            <div class="mb-2 text-sm text-gray-600">Respondendo a mensagem #{{ $replyTo }} <button wire:click="clearReply" class="text-red-500 ml-2">Cancelar</button></div>
        @endif

        <textarea wire:model.defer="newMessage" rows="3" class="w-full p-3 rounded-xl border resize-none dark:bg-zinc-900" placeholder="Escreva uma mensagem..."></textarea>

        <div class="flex justify-end mt-2">
            <button wire:click="sendMessage" class="px-4 py-2 bg-indigo-600 text-white rounded-xl">Enviar</button>
        </div>
    </div>
</div>
