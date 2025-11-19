<p>Olá,</p>

<p>Há uma nova mensagem na atividade: <strong>{{ $activity->title }}</strong>.</p>

<p><strong>{{ $sender->name }}:</strong></p>
<p>{{ $message->content }}</p>

<p>Para ver e responder acesse: <a href="{{ url('/activities/'.$activity->id) }}">{{ url('/activities/'.$activity->id) }}</a></p>

<p>— Sistema</p>
