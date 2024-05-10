@extends('layouts.app')

@section('content')
<div class="container my-3">
    <strong>Email: </strong> {{ (reset($messages_filter))['email'] }} <br />
    @foreach ($messages_filter as $message)
    <strong>Body: </strong> {{ $message['body'] }} <br />
    <strong>Sent at: </strong> {{ $message['sent'] }} <br />
    @endforeach
</div>
@endsection

