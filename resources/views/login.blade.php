@extends('components.base')
@section('content')
    <div class="flex justify-center items-center h-screen">
        <form class="flex flex-col gap-6 bg-slate-200 p-10" action="{{route('log')}}">
            @csrf
            <input class="p-2" type="email" name="email" placeholder="E-mail cím">
            <input class="p-2" type="password" name="password" placeholder="jelszó">
            <div class="flex gap-4">
                <input type="submit" value="Bejelentkezés" class="hover:text-white cursor-pointer bg-green-600 p-2 rounded-xl">
                <a href="{{route('registration')}}" class="hover:text-blue-900 text-blue-600 cursor-pointer mt-2">Még nem regisztráltam</a>
            </div>
        </form>
    </div>
@endsection
