@extends('layouts.app')
@section('title', 'Sponsorizzazioni')

@section('content')
<div class="container my-5">
    <h2><strong>Storico sponsorizzazioni</strong></h2>
    @foreach ($sponsors as $sponsor)
    <div @class([
        'my-2 p-2 text-light rounded',
        'standard-bg' => $sponsor->name == 'Standard',
        'gold-bg' => $sponsor->name == 'Gold',
        'platinum-bg' => $sponsor->name == 'Platinum',
        ])>
        <h4><strong>Piano: </strong>{{ $sponsor->name }}</h4>
        <h5><strong>Inizio sponsorizzazione: </strong>{{ $sponsor->pivot->created }}</h5>
        <h5><strong>Fine sponsorizzazione: </strong>{{ $sponsor->pivot->expiry }}</h5>
    </div>
    @endforeach
</div>

@endsection