@extends('layouts.app')

@section('content')
    <div class="container my-5 d-flex justify-content-center">
        <div class="message-container  p-3 bg-white rounded shadow">
            <div class="d-flex justify-content-between pb-5">
                <div>

                    <strong>From: </strong> {{ reset($messages_filter)['email'] }} <br />
                    @foreach ($messages_filter as $message)
                </div>
                <div>

                    <span class="fw-bold">date: </span><span class="fw-light ">{{ $message['sent'] }}</span> <br />
                </div>

            </div>

            <div class="bg-body-secondary p-3  rounded shadow">
                {{ $message['body'] }} <br />

            </div>
            @endforeach

        </div>
    </div>
@endsection
