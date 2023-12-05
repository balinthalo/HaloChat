@extends('components.base')
@section('content')
    <div class="flex justify-center items-center h-screen">
        <div class="p-8">
            <div class="flex flex-col gap-y-4 overflow-hidden mb-8">
                @foreach ($chats as $chat)
                    <div class="grid lg:grid-cols-2 lg:gap-4">
                        <a class="bg-slate-500 hover:bg-slate-500 text-slate-50 rounded-lg p-4 cursor-pointer" href="{{ route('chat.show', ['chat' => $chat->id]) }}">
                            {{ $chat->name }}
                        </a>
                        <div class="flex">
                            <a class="hover:bg-slate-500 rounded-lg hover:text-slate-50 p-4 cursor-pointer" href="{{ route('chat.invite', ['chat' => $chat->id]) }}">Meghívás</a>
                            <a class="hover:bg-slate-500 rounded-lg hover:text-slate-50 p-4 cursor-pointer" href="{{ route('chat.edit', ['chat' => $chat->id]) }}" class="cursor-pointer">Szerkesztés</a>
                            <form class="hover:bg-slate-500 p-4 rounded-lg hover:text-slate-50 cursor-pointer" action="{{ route('chat.delete', $chat->id) }}" method="post">
                                @csrf
                                {{ method_field('DELETE') }}
                                <input type="submit" class="cursor-pointer" value="Törlés">
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="bg-slate-200 hover:bg-slate-500 p-4 cursor-pointer rounded-lg hover:text-slate-50" href="{{ route('chat.create') }}">Új beszélgetés</a>
        </div>
    </div>
@endsection
