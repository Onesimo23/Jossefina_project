<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DialogueNotificationController extends Controller
{
    public function latest()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['count' => 0, 'message' => null]);
        }

        $latest = $user->unreadNotifications()->where('type', \App\Notifications\DialogueMessagePosted::class)->latest()->first();

        if (!$latest) {
            return response()->json(['count' => 0, 'message' => null]);
        }

        $data = $latest->data;

        return response()->json([
            'count' => $user->unreadNotifications()->where('type', \App\Notifications\DialogueMessagePosted::class)->count(),
            'project_title' => $data['project_title'] ?? null,
            'activity_title' => $data['activity_title'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'notification_id' => $latest->id,
        ]);
    }

    public function markAllRead(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['ok' => false], 401);
        }

        $user->unreadNotifications()->where('type', \App\Notifications\DialogueMessagePosted::class)->update(['read_at' => now()]);

        return response()->json(['ok' => true]);
    }
}
