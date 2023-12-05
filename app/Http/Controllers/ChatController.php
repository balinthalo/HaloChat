<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    private function checkPermission(Chat $chat, User $user = null) {
        if ($user === null) $user = auth()->user();
        $userIsMember = $chat->users()->where('user_id', $user->id)->exists();
        if ($userIsMember === false) {
            abort(403);
        }
    }

    public function index (Request $request) {
        $chats = Chat::leftJoin('chat_and_users', 'chat_and_users.chat_id', '=', 'chats.id')
            ->where('chat_and_users.user_id', $request->user()->id)
            ->get();
        return view('chats.index')->with(['chats' => $chats]);
    }

    public function create () {
        $users = User::get();
        return view('chats.create')->with(['users' => $users]);
    }

    public function show (Request $request, Chat $chat) {
        $this->checkPermission($chat);
        $users = User::leftJoin('chat_and_users', 'chat_and_users.user_id', '=', 'users.id')
        ->where('chat_and_users.chat_id', $chat->id)
        ->get();
        return view('chats.show')->with(['chat' => $chat, 'users' => $users]);
    }

    public function store (Request $request) {
        $request->validate([
            'name' => ['required']
        ]);

        $data['name'] = $request->name;
        $chat = Chat::create($data);
        $chat->save();

        $user = User::find($request->user);
        $chat->users()->attach($user);

        if ($user->id !== $request->user()->id) {
            $chat->users()->attach($request->user());
        }

        return to_route('chat.index');
    }

    public function edit (Request $request, Chat $chat) {
        $this->checkPermission($chat);
        $users = User::get();

        return view('chats.edit')->with(['chat' => $chat, 'users' => $users]);
    }

    public function update (Request $request, Chat $chat) {
        $this->checkPermission($chat);
        $request->validate([
            'name' => ['required']
        ]);
        $chat->name = $request->name;
        $chat->save();

        return to_route('chat.index');
    }

    public function delete (Request $request, Chat $chat) {
        $this->checkPermission($chat);
        $chat->delete();

        return to_route('chat.index');
    }

    public function invite (Request $request, Chat $chat) {
        $this->checkPermission($chat);
        $chatUsers = DB::table('chat_and_users')->where('chat_id', $chat->id)->get()->pluck('user_id');
        $users = User::whereNotIn('id', $chatUsers)->get();

        return view('chats.invite')->with(['users' => $users, 'chat' => $chat]);
    }

    public function add (Request $request, Chat $chat) {
        $this->checkPermission($chat);
        $request->validate([
            'user' => ['exists:users,id'] // user_id amit menteni kell
        ]);

        $user = User::find($request->input('user'));
        if ($chat->users()->where('user_id', $user->id)->exists()) {
            throw new Exception('A felhasználó már hozzávan adva a chathez.');
        }

        $chat->users()->attach($user);

        return to_route('chat.index');
    }
}
