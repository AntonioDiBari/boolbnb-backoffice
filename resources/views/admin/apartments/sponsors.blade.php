@extends('layouts.app')
@section('title', 'Sponsorizzazioni Appartamento')

@section('content')
    <div class="container my-5 position-relative">
        <div class="navigation position-absolute">
            <a class="btn btn-link" href="{{ route('admin.apartments.show', $apartment) }}"><i
                    class="fa-solid fa-reply"></i></a>
        </div>
        <h3 class="my-3">Sponsorizza {{ $apartment->title_desc }}</h3>
        <div class="bg-light p-2 rounded mb-3">
            <form action="{{ route('admin.apartments.sponsorSync', $apartment) }}">
                <h5>Piani disponibili:</h5>
                <div class="row">
                    @foreach ($allSponsors as $sponsor)
                        <div class="col-4">
                            <div class="card d-flex flex-row justify-content-center align-items-center fs-5">
                                <span class="fw-bold me-2">{{ $sponsor->name }}</span> per {{ $sponsor->duration }} ore a
                                soli
                                <span class="fw-bold ms-2">{{ $sponsor->price }} €</span>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-4 my-2">
                        <select name="sponsor" id="sponsor" class="form-select" required>
                            <option value="" class="d-none">Seleziona un piano da sottoscrivere</option>
                            @foreach ($allSponsors as $sponsor)
                                <option value="{{ $sponsor->id }}">{{ $sponsor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="dropin-container"></div>
                <div id="submit-button" class="button button--small btn-primary">Inserisci carta</div>
                <button type="submit" class="button button--small button--green">Paga</button>
            </form>
        </div>
        <h2><strong>Storico sponsorizzazioni</strong></h2>
        @forelse ($sponsors as $sponsor)
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
        @empty
            0 Sponsorizzazioni
        @endforelse

    </div>

@endsection
@section('js')
    <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>
    <script>
        var button = document.querySelector('#submit-button');

        braintree.dropin.create({
            authorization: 'sandbox_ykg76v4h_pmhgbpstzkvsmr8w',
            selector: '#dropin-container'
        }, function(err, instance) {
            button.addEventListener('click', function() {
                instance.requestPaymentMethod(function(err, payload) {
                    // Submit payload.nonce to your server
                });
            })
        });
    </script>
@endsection
