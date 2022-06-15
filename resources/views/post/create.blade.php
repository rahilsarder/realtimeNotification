@extends('post.index')
@section('chat')
<post-component :user="{{ $user }}" :post="{{ $posts }}" :roomid="'{{ $roomID }}'" :room="{{ $room }}"></post-component>
@endsection