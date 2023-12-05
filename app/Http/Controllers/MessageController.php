<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private function checkPermission(Chat $chat, User $user = null) {
        if ($user === null) $user = auth()->user();
        $userIsMember = $chat->users()->where('user_id', $user->id)->exists();
        if ($userIsMember === false) {
            abort(403);
        }
    }

    public function store (Request $request, Chat $chat) {
        $this->checkPermission($chat);
        $request->validate([
            'text' => ['required']
        ]);

        $data['text'] = strip_tags($request->text);
        $data['chat_id'] = $chat->id;
        $data['sender_id'] = $request->user()->id;
        $message = Message::create($data);
        $message->save();
        return to_route('chat.show', ['chat' => $chat->id]);
    }

    public function download (Request $request, Chat $chat) {
        $this->checkPermission($chat);
        $messages = Message::where('chat_id', $chat->id)->get();
        $users = User::get();

        return response()->json([
            'messages' => $messages,
            'users' => $users,
        ]);
    }

    public function delete(){

    }
}
