@extends('layouts.app')

@section('title', empty($apartment->id) ? 'Aggiungi Appartamento' : 'Modifica Appartamento')

@section('content')
    <div class="container my-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li> <br>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1>{{ empty($apartment->id) ? 'Aggiungi Appartamento' : 'Modifica Appartamento' }}</h1>
        <form
            action="{{ empty($apartment->id) ? route('admin.apartments.store') : route('admin.apartments.update', $apartment) }}"
            method="POST" enctype="multipart/form-data">
            @csrf

            @if (!empty($apartment->id))
                @method('PATCH')
            @endif

            <div class="row">
                <div class="col-10">
                    <div class="row">
                        <div class="col-8">
                            <label for="title_desc" class="form-label">Nome Appartamento</label>
                            <input type="text" class="form-control @error('title_desc') is-invalid @enderror"
                                id="title_desc" name="title_desc" value="{{ old('title_desc') ?? $apartment->title_desc }}"
                                required />
                            @error('title_desc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="country" class="form-label">Nazione</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" id="country"
                                name="country"
                                @if (isset($addresses)) value="{{ old($addresses[1]) ?? $addresses[1] }}" @endif
                                required />
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="city" class="form-label">Città</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                                name="city"
                                @if (isset($addresses)) value="{{ old($addresses[2]) ?? $addresses[2] }}" @endif
                                required />
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="address" class="form-label">Via</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                                name="address"
                                @if (isset($addresses)) value="{{ old($addresses[0]) ?? $addresses[0] }}" @endif
                                required />
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="n_address" class="form-label">Civico</label>
                            <input type="text" class="form-control @error('n_address') is-invalid @enderror"
                                id="n_address" name="n_address"
                                @if (isset($addresses)) value="{{ old($addresses[3]) ?? $addresses[3] }}" @endif
                                required />
                            @error('n_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="n_rooms" class="form-label">N° Stanze</label>
                            <input type="number" min="1" max="5"
                                class="form-control @error('n_rooms') is-invalid @enderror" id="n_rooms" name="n_rooms"
                                value="{{ old('n_rooms') ?? $apartment->n_rooms }}" required />
                            @error('n_rooms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="n_bathrooms" class="form-label">N° Bagni</label>
                            <input type="number" min="1" max="3"
                                class="form-control @error('n_bathrooms') is-invalid @enderror" id="n_bathrooms"
                                name="n_bathrooms" value="{{ old('n_bathrooms') ?? $apartment->n_bathrooms }}" required />
                            @error('n_bathrooms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="n_beds" class="form-label">N° Letti</label>
                            <input type="number" min="1" max="4"
                                class="form-control @error('n_beds') is-invalid @enderror" id="n_beds" name="n_beds"
                                value="{{ old('n_beds') ?? $apartment->n_beds }}" required />
                            @error('n_beds')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="square_mts" class="form-label">Metri quadri</label>
                            <input type="number" min="80" max="170"
                                class="form-control @error('square_mts') is-invalid @enderror" id="square_mts"
                                name="square_mts" value="{{ old('square_mts') ?? $apartment->square_mts }}" required />
                            @error('square_mts')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <section class="mb-4 d-flex gap-3">
                                <div>
                                    <label for="img" class="form-label">Immagine rappresentativa
                                        dell'appartamento</label>
                                    <input class="form-control @error('img') is-invalid @enderror" type="file"
                                        name="img" id="img">
                                    @error('img')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if (isset($apartment->img))
                                    <div>
                                        <label clas="form-label">Precedente Immagine inserita</label><br>
                                        <img src="{{ asset('storage/' . $apartment->img) }}" alt="">
                                    </div>
                                @endif
                            </section>
                        </div>
                        <div class="col-3">
                            <input class="form-check-input" type="checkbox" value="1" name="visible"
                                id="visible" {{ $apartment->visible ? 'checked' : '' }}>
                            <label class="form-check-label" for="visible">
                                Mettere tra i pubblicati
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    @foreach ($services as $service)
                        <input type="checkbox" id="services-{{ $service->id }}" name="services[]"
                            value="{{ $service->id }}" class="form-check-input @error('services') is-invalid @enderror"
                            {{ in_array($service->id, old('services', $apartment->services->pluck('id')->toArray())) ? 'checked' : '' }}>
                        <label for="services-{{ $service->id }}"
                            class="form-check-label">{{ $service->name }}</label><br>
                    @endforeach
                    @error('services')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                    <button class="btn btn-secondary">{{ empty($apartment->id) ? 'Aggiungi' : 'Modifica' }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
