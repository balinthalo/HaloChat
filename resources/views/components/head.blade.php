@auth
    <div class="bg-gray-400 py-2 px-6 grid grid-cols-2">
        <div>
            @if (Request::url() !== route('chat.index'))
                <button onclick="window.location = '/';" class="text-xl">Home</button>
            @endif
        </div>
        <div class="grid justify-self-end">
            <a href="{{route('logout')}}">Log out</a>
        </div>
    </div>
@endauth
