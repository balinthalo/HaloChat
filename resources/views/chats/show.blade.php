@extends('components.base')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="grid grid-cols-1 gap-4 max-w-max mx-auto items-end">
        <div class="space-y-2 px-4 pb-4">
            <div class="font-bold text-2xl whitespace-nowrap overflow-hidden overflow-ellipsis">{{$chat->name}}</div>
            <div class="text-xs">
                <span>Tagok:</span>
                @foreach ($users as $user)
                    <span class="bg-slate-200 text-slate-600 py-1 px-2 rounded-lg">{{ $user->name }}</span>
                @endforeach
            </div>
        </div>
        <div>
            <!-- JS-hez szükséges paraméterek -->
            <div id="chat_id" chat_id="{{ $chat->id }}"></div>
            <div id="auth_user_id" auth_user_id="{{ auth()->user()->id }}"></div>

            <div id="messages" class="p-8 space-y-4 h-[calc(100vh-200px)] overflow-auto"></div>

            <div class="flex px-4">
                <input type="text" name="text" class="w-full p-2 bg-slate-100 rounded-l-lg">
                <input type="submit" class="bg-slate-300 hover:bg-slate-500 hover:text-slate-50 p-2 rounded-r-lg cursor-pointer" value=">>">
            </div>
        </div>
    </div>
@endsection
