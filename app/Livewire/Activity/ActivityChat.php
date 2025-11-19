<?php

namespace App\Livewire\Activity;

use Livewire\Component;
use App\Models\Activity;
use App\Models\DialogueMessage;
use App\Models\Enrollment;
use App\Notifications\DialogueMessagePosted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ActivityChat extends Component {

    // Injetada via Livewire
    public Activity $activity;

    public $newMessage = '';
    public $parentMessageId = null;

    protected $rules = [
        'newMessage' => 'required|min:1|max:1000'
    ];

    public function mount(Activity $activity) {
        $this->activity = $activity;

        // Não armazenamos a coleção em propriedade pública (evita problemas de serialização)

        // Permissões de acesso (mantidas)
        if (!Auth::check()) {
            abort(403);
        }

        if (
            Auth::user()->role !== 'coordinator' &&
            ! $activity->enrollments()->where('user_id', Auth::id())->exists()
        ) {
            abort(403);
        }

        $this->loadMessages();
    }

    public function loadMessages() {
        // Método mantido caso queira reuso, retornando as mensagens como coleção
        return DialogueMessage::where('activity_id', $this->activity->id)
            ->whereNull('parent_id')
            ->with('user', 'replies.user')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function sendMessage() {
        $this->validate();

        // cria a mensagem e retorna o modelo
        $message = DialogueMessage::create([
            'project_id'  => $this->activity->project_id,
            'activity_id' => $this->activity->id,
            'user_id'     => Auth::id(),
            'content'     => $this->newMessage,
            'parent_id'   => $this->parentMessageId,
        ]);

        $this->newMessage = '';
        $this->parentMessageId = null;

        // Notifica inscritos (database + mail via Notification)
        $enrolledUsers = Enrollment::where('activity_id', $this->activity->id)
            ->with('user')
            ->get()
            ->pluck('user')
            ->filter()
            ->unique('id')
            ->values();

        // remover remetente
        $targets = $enrolledUsers->reject(fn($u) => $u->id === Auth::id())->all();

        if (!empty($targets)) {
            Notification::send($targets, new DialogueMessagePosted($message));
        }

        // Dispara evento para o JS/Livewire do front atualizar/rolar o chat
        $this->dispatch('message-sent');

        // evento DOM para layout atualizar (local)
        $this->dispatch('dialogue-message-sent');
    }

    public function replyTo($messageId) {
        $this->parentMessageId = $messageId;
    }

    public function clearReply() {
        $this->parentMessageId = null;
    }

    public function render() {
        // Buscamos as mensagens aqui e passamos para a view (sem expô-las como propriedade pública)
        $messages = $this->loadMessages();
        // Dispara evento de scroll apenas na primeira renderização se quiser (JS já lida com evento message-sent)
        return view('livewire.activity.activity-chat', [
            'messages' => $messages,
        ]);
    }
}
