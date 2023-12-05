@extends('components.base')
@section('content')
    <div class="flex justify-center items-center h-screen px-40">
        <form action="{{route('chat.update', ['chat' => $chat->id])}}" class="flex flex-col bg-slate-500 p-8 gap-6" method="POST">
            @csrf
            <input class="p-2" name="name" type="text" placeholder="beszélgetés új neve" value="{{$chat->name}}">
            <input type="submit" value="Beszélgetés átnevezése" class="bg-green-600 p-2 rounded-xl hover:text-slate-200 cursor-pointer">
        </form>
    </div>
@endsection
