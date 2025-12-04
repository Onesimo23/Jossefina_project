<?php

namespace App\Livewire\Activity;

use Livewire\Component;
use App\Models\Activity;
use App\Models\DialogueMessage;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DialogueMessageNotification;

class DialoguePanel extends Component
{
    public $activityId;
    public $activity;
    public $messages;
    public $newMessage = '';
    public $replyTo = null;

    protected $listeners = ['messageSent' => 'loadMessages'];

    public function mount($activityId)
    {
        $this->activityId = $activityId;
        $this->activity = Activity::find($activityId);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = DialogueMessage::with('user','replies.user')
            ->where('activity_id', $this->activityId)
            ->whereNull('parent_id')
            ->orderBy('created_at','asc') // <-- ordem crescente
            ->get();
    }

    public function setReplyTo($messageId)
    {
        $this->replyTo = $messageId;
    }

    public function clearReply()
    {
        $this->replyTo = null;
    }

    public function sendMessage()
    {
        if (!Auth::check()) {
            $this->dispatch('notify', type: 'error', message: 'Faça login para enviar mensagens.');
            return;
        }

        $content = trim($this->newMessage);
        if (!$content) return;

        $message = DialogueMessage::create([
            'activity_id' => $this->activityId,
            'project_id' => $this->activity->project_id,
            'user_id' => Auth::id(),
            'content' => $content,
            'parent_id' => $this->replyTo,
        ]);

        $this->newMessage = '';
        $this->replyTo = null;
        $this->loadMessages();
        $this->dispatch('messageSent');

        // Notificar por email todos os inscritos (exceto o remetente)
        $enrolledUsers = Enrollment::where('activity_id', $this->activityId)->with('user')->get()->pluck('user')->filter()->unique('id');

        foreach ($enrolledUsers as $user) {
            if ($user->id == Auth::id()) continue;
            if ($user->email) {
                Mail::to($user->email)->send(new DialogueMessageNotification($message, $this->activity));
            }
        }
    }

    public function render()
    {
        return view('livewire.activity.dialogue-panel');
    }
}
