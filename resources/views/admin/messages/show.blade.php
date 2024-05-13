@extends('layouts.app')

@section('content')
    <div class="container my-5 d-flex justify-content-center">
        <div class="message-container  p-3 bg-white rounded shadow">
            <div class="d-flex flex-column justify-content-between pb-5">
                <div class="mb-5">

                    <strong>From: </strong> {{ reset($messages_array)['email'] }} <br />
                </div>
                @foreach ($messages_array as $message)
                    <div class="d-flex justify-content-end mb-2">

                        <span class="fw-bold ">date: </span><span class="fw-light ">{{ $message['sent'] }}</span> <br />
                    </div>

                    <div class="bg-body-secondary p-3  rounded shadow mb-5">
                        {{ $message['body'] }} <br />

                    </div>
                @endforeach
            </div>


        </div>
    </div>
@endsection
