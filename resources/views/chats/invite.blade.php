@extends('components.base')
@section('content')
    <div class="flex justify-center items-center h-screen px-40">
        @if (count($users) === 0)
            Nincs meghívható felhasználó!
        @else
            <form action="{{ route('chat.add', ['chat' => $chat->id]) }}" class="flex flex-col bg-slate-500 p-8 gap-6" method="POST">
                @csrf
                <select name="user">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <input type="submit" value="Meghívás" class="bg-green-600 p-2 rounded-xl hover:text-slate-200 cursor-pointer">
            </form>
        @endif
    </div>
@endsection
