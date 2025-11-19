<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\DialogueMessage;
use App\Models\Activity;

class DialogueMessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $messageModel;
    public $activity;
    public $sender;

    public function __construct(DialogueMessage $message, Activity $activity)
    {
        $this->messageModel = $message;
        $this->activity = $activity;
        $this->sender = $message->user;
    }

    public function build()
    {
        return $this->subject("Nova mensagem na atividade: {$this->activity->title}")
                    ->view('emails.dialogue_message_notification')
                    ->with([
                        'message' => $this->messageModel,
                        'activity' => $this->activity,
                        'sender' => $this->sender,
                    ]);
    }
}
