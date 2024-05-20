@extends('layouts.app')
@section('title', 'I miei appartamenti')

@section('content')
    <div class="container my-3">
        <div class="d-flex justify-content-between">
            <h1 class="fs-3"><strong>Lista appartamenti</strong></h1>
            <a href="{{ route('admin.apartments.create') }}">
                <div class="btn btn-primary">Inserisci Appartamento</div>
            </a>
        </div>
        <div class="container alert-container">
            @if (session('message'))
                <div class="alert {{ session('type') }} alert-dismissible my-2">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="row">
            @forelse ($apartments as $key => $apartment)

            <div class="primary-col col-6 g-4 border-bottom pb-2">
                <a href="{{ route('admin.apartments.show', $apartment) }}">
                    <div class="card h-100 border-0">
                        <div class="row">
                            <div class="col-5">
                                <div class="rounded-2 overflow-hidden position-relative">
                                    <img class="img-fluid w-100 img-fixed"
                                    @if (str_starts_with($apartment->img, 'img')) src="{{ asset($apartment->img) }}" @elseif (str_starts_with($apartment->img, 'uploads')) src="{{ asset('storage/' . $apartment->img) }}"  @else src="https://placehold.co/600x400" @endif
                                    alt="">
                                    @if (!empty($sponsors[$key]))
                                    @php 
                                    $created_dates = [];
                                    foreach ($sponsors[$key] as $sponsor) {
                                        array_push($created_dates, $sponsor['pivot']['created']);
                                    }
                                    array_multisort($created_dates, SORT_ASC, $sponsors[$key]);
                                    $stop = false;
                                    @endphp
                                    @foreach ($sponsors[$key] as $sponsor)
                                    @if ($sponsor['pivot']['expiry'] > date("Y-m-d H:i:s") && $stop == false)
                                        <div @class([
                                            'sponsor-icon',
                                            'standard-text' => $sponsor['id'] == 1,
                                            'gold-text' => $sponsor['id'] == 2,
                                            'platinum-text' => $sponsor['id'] == 3,
                                            ])><i class="fa-solid fa-crown"></i>
                                        </div>
                                        @php $stop = true @endphp
                                    @endif
                                        @endforeach
                                    @endif
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="card-body p-0 pt-1 d-flex flex-column justify-content-between">
                                        <div>
                                            <h2 class="fs-5"><strong>{{ $apartment->title_desc }}</strong></h2>
                                            <p class="m-0">{{ $addresses[$key] }}</p>
                                        </div>
                                        <p class="m-0">{{ $apartment->square_mts }}mt²</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <h1>Nessun appartamento</h1>
            @endforelse
        </div>
    </div>
@endsection
