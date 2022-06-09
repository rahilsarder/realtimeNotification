@extends('layouts.app')
@section('content')
<post-component :user="{{ $user }}" :post="{{ $posts }}"></post-component>
@endsection