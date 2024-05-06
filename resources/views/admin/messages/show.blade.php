@extends('layouts.app')

<div class="container my-3">
    <strong>Email: </strong> {{ $message->email }} <br />
    <strong>Body: </strong> {{ $message->body }} <br />
    <strong>Sent at: </strong> {{ $message->sent }} <br />

</div>
