<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\DialogueMessage;

class DialogueMessagePosted extends Notification
{
    use Queueable;

    public DialogueMessage $messageModel;

    public function __construct(DialogueMessage $message)
    {
        $this->messageModel = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // database para header, mail para Mailpit
    }

    public function toDatabase($notifiable)
    {
        return [
            'message_id'    => $this->messageModel->id,
            'activity_id'   => $this->messageModel->activity_id,
            'project_id'    => $this->messageModel->project_id,
            'project_title' => optional($this->messageModel->project)->title,
            'activity_title'=> optional($this->messageModel->activity)->title,
            'excerpt'       => \Illuminate\Support\Str::limit($this->messageModel->content, 120),
            'sender_id'     => $this->messageModel->user_id,
            'sender_name'   => optional($this->messageModel->user)->name,
            'created_at'    => $this->messageModel->created_at->toDateTimeString(),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nova mensagem na atividade: ' . optional($this->messageModel->activity)->title)
            ->line(optional($this->messageModel->user)->name . ' enviou uma mensagem:')
            ->line($this->messageModel->content)
            ->action('Ver atividade', url('/activities/' . $this->messageModel->activity_id))
            ->line('— Sistema');
    }
}
