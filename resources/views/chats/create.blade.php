@extends('components.base')
@section('content')
    <div class="flex justify-center items-center h-screen px-40">
        <form action="{{route('chat.store')}}" class="flex flex-col bg-slate-500 p-8 gap-6" method="POST">
            @csrf
            <input class="p-2" name="name" type="text" placeholder="új beszélgetés neve">
            <select name="user">
                @foreach ($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
            <input type="submit" value="Beszélgetés létrehozása" class="bg-green-600 p-2 rounded-xl hover:text-slate-200 cursor-pointer">
        </form>
    </div>
@endsection
