@extends('layouts.app')

@section('title', empty($apartment->id) ? 'Aggiungi Appartamento' : 'Modifica Appartamento')

@section('content')
    <div class="container my-4 position-relative">
        <div class="navigation position-absolute">
            <a class="btn btn-link" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                    class="fa-solid fa-reply"></i></a>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li> <br>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (isset($address))
            <p class="d-none" id="addressEdit">{{ $address }}</p>
        @endif
        <h1>{{ empty($apartment->id) ? 'Aggiungi Appartamento' : 'Modifica Appartamento' }}</h1>
        <form
            action="{{ empty($apartment->id) ? route('admin.apartments.store') : route('admin.apartments.update', $apartment) }}"
            method="POST" enctype="multipart/form-data" id="apartment-form">
            @csrf

            @if (!empty($apartment->id))
                @method('PATCH')
            @endif

            <div class="row py-5">
                <div class="col-10">
                    <div class="row pb-5">
                        <div class="col-10 ">
                            <label for="title_desc" class="form-label">Nome Appartamento</label>
                            <input type="text" class="form-control @error('title_desc') is-invalid @enderror"
                                id="title_desc" name="title_desc"
                                value="{{ old('title_desc') ?? $apartment->title_desc }}" />
                            @error('title_desc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row pb-5">
                        <div class="col-10 position-relative ">
                            <label for="address" class="form-label m-0">Indirizzo</label>
                            <div id="searchbox">
                            </div>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row pb-5 ">
                        <div class="col-5">
                            <label for="n_rooms" class="form-label">N° Stanze</label>
                            <input type="number" class="form-control @error('n_rooms') is-invalid @enderror" id="n_rooms"
                                name="n_rooms" value="{{ old('n_rooms') ?? $apartment->n_rooms }}" required />
                            @error('n_rooms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-5">
                            <label for="n_bathrooms" class="form-label">N° Bagni</label>
                            <input type="number" class="form-control @error('n_bathrooms') is-invalid @enderror"
                                id="n_bathrooms" name="n_bathrooms"
                                value="{{ old('n_bathrooms') ?? $apartment->n_bathrooms }}" required />
                            @error('n_bathrooms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row pb-5 ">
                        <div class="col-5">
                            <label for="n_beds" class="form-label">N° Letti</label>
                            <input type="number" class="form-control @error('n_beds') is-invalid @enderror" id="n_beds"
                                name="n_beds" value="{{ old('n_beds') ?? $apartment->n_beds }}" required />
                            @error('n_beds')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-5">
                            <label for="square_mts" class="form-label">Metri quadri</label>
                            <input type="number" class="form-control @error('square_mts') is-invalid @enderror"
                                id="square_mts" name="square_mts" value="{{ old('square_mts') ?? $apartment->square_mts }}"
                                required />
                            @error('square_mts')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-11">
                            <section class="mb-4 d-flex gap-5">
                                <div>
                                    <label for="img" class="form-label">Immagine rappresentativa
                                        dell'appartamento (opzionale)</label>
                                    <input class="form-control @error('img') is-invalid @enderror" type="file"
                                        name="img" id="img">
                                    @error('img')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if (isset($apartment->img))
                                    <div class="">
                                        <label clas="form-label ">Precedente Immagine inserita</label><br>
                                        <img class="shadow"
                                            @if (str_starts_with($apartment->img, 'img')) src="{{ asset($apartment->img) }}" 
                                        @elseif (str_starts_with($apartment->img, 'uploads')) src="{{ asset('storage/' . $apartment->img) }}" @endif
                                            alt="">
                                    </div>
                                @endif
                            </section>
                        </div>
                        <div class="col-3 pb-3">
                            <input class="form-check-input" type="checkbox" value="1" name="visible" id="visible"
                                {{ $apartment->visible ? 'checked' : '' }}>
                            <label class="form-check-label" for="visible">
                                Mettere tra i pubblicati
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-2 p-3 services-collum rounded shadow">
                    @foreach ($services as $service)
                        <div class="mb-5">
                            <input type="checkbox" id="services-{{ $service->id }}" name="services[]"
                                value="{{ $service->id }}"
                                class="form-check-input @error('services') is-invalid @enderror"
                                {{ in_array($service->id, old('services', $apartment->services->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <i class="fa-solid fa-{{ $service->logo }} mx-2"></i>
                            <label for="services-{{ $service->id }}"
                                class="form-check-label">{{ $service->name }}</label><br>

                        </div>
                    @endforeach
                    @error('services')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                    <button type="submit"
                        class="btn btn-success">{{ empty($apartment->id) ? 'Aggiungi' : 'Modifica' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css"
        href="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox.css" />
@endsection

@section('js')
    {{-- AUTOCOMPLETAMENTO --}}
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js">
    </script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js">
    </script>
    <script>
        let options = {
            searchOptions: {
                key: "m6bLjp96DQhl3wwfT6yrGKFNU7uF0doB",
                language: "it-IT",
                limit: 5
            },
            autocompleteOptions: {
                key: "m6bLjp96DQhl3wwfT6yrGKFNU7uF0doB",
                language: "it-IT",
            },
        }
        let address = document.getElementById("addressEdit");
        let ttSearchBox = new tt.plugins.SearchBox(tt.services, options)
        let searchBoxHTML = ttSearchBox.getSearchBoxHTML()
        document.getElementById('searchbox').append(searchBoxHTML);
        const inputBox = document.querySelector('.tt-search-box-input');
        inputBox.setAttribute('name', 'address');
        inputBox.setAttribute('id', 'address');
        inputBox.setAttribute('required', "");
        if (address != null) {
            inputBox.setAttribute('value', address.innerHTML);
        }
    </script>

    {{-- VALIDAZIONI CLIENT --}}
    <script>
        const aptForm = document.getElementById('apartment-form');

        aptForm.addEventListener("submit", function(event) {
            event.preventDefault();

            const {
                title_desc,
                address,
                n_rooms,
                n_bathrooms,
                n_beds,
                square_mts
            } = aptForm.elements;

            if (isEmpty(title_desc.value)) {
                alert("Il titolo non può essere vuoto!");
                return;
            }

            if (isEmpty(address.value)) {
                alert("L'indirizzo non può essere vuoto!");
                return;
            }

            if (isNegative(n_rooms.value) || (n_rooms.value == 0 || n_rooms.value > 255)) {
                alert("Inserire un valore di stanze valido");
                return;
            }

            if (isNegative(n_bathrooms.value) || (n_bathrooms.value == 0 || n_bathrooms.value > 255)) {
                alert("Inserire un valore di bagni valido");
                return;
            }

            if (isNegative(n_beds.value) || (n_beds.value == 0 || n_beds.value > 255)) {
                alert("Inserire un valore di letti valido");
                return;
            }

            if (isNegative(square_mts.value) || (square_mts.value < 10 || square_mts.value > 255)) {
                alert("Inserire un valore di metrature valido");
                return;
            }

            aptForm.submit();
            aptForm.reset();
        })

        function isEmpty(string) {
            console.log(string.length);
            if (string.length == 0) {
                return true;
            } else {
                return false;
            }
        }

        function isNegative(number) {
            if (number < 0) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endsection

@section('modal')
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tornare indietro ?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Perderai tutti i progressi e informazioni inserite.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                    <a href="{{ empty($apartment->id) ? route('admin.apartments.index') : route('admin.apartments.show', $apartment) }}"type="button"
                        class="btn btn-primary">Indietro</a>
                </div>
            </div>
        </div>
</div>@endsection
