@extends('layouts.app')

@section('content')

<div class="container py-5 px-4">
    <div class="row rounded-lg overflow-hidden shadow">
        <!-- Users box-->
        <div class="col-5 px-0">
            <div class="bg-white pb-5">
                <div class="bg-gray px-4 py-2 bg-light">
                    <p class="h5 mb-0 py-1">Recent</p>
                </div>

                <div class="messages-box">
                    <div class="list-group rounded-0">
                        @forelse($chat_rooms as $room)
                        <a
                            href="{{ url('/chat/'.$room->chat_id) }}"
                            class="list-group-item list-group-item-action list-group-item-light rounded-0"
                        >
                            <div class="media">
                                <img
                                    src="https://avatar.oxro.io/avatar.svg?name={{ $room->name }}"
                                    alt="user"
                                    width="50"
                                    class="rounded-circle mt-2"
                                />
                                <div class="media-body ml-4">
                                    <div
                                        class="d-flex align-items-center justify-content-between mb-3"
                                    >
                                        <h6 class="mb-0 mt-2">{{ $room->name }}</h6>
                                        
                                    </div>
                                </div>
                            </div>
                        </a>
                        @empty
                        <p>Oopsie! Don't have any rooms!</p>
                        @endforelse
                    </div>
                </div>
                <form action="/chat/createRoom" method="POST" class="d-flex justify-content-between ">
                    @csrf
                    <input type="text" name="name" placeholder="Room Name" class="w-100 form-control">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i></button>
                </form> 
            </div>
        </div>
        @yield('chat')
    </div>
</div>

{{-- <form action="/post/createRoom" method="POST" class="d-flex justify-content-between">
                    @csrf
                    <input type="text" name="name" placeholder="Room Name" class="w-100 form-control">
                    <input type="submit" value="Create Room" class="btn btn-primary">
                </form>  --}}



                {{-- @forelse ($chat_rooms as $room)
                @empty
                <h1 class="alert">Don't have any rooms yet? Try making one!</h1>
                @endforelse --}}
@endsection


