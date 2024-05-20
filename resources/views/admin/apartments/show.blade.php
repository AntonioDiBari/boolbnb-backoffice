@extends('layouts.app')
@section('title', 'Dettaglio appartamento')

@section('content')
    <div class="container my-3 position-relative">
        <div class="navigation position-absolute">
            <a class="btn btn-link" href="{{ route('admin.apartments.index') }}"><i class="fa-solid fa-reply"></i></a>
        </div>
        <div class="detail-box d-flex flex-column justify-content-center">
            <h1 class="fs-3 text-color">
                <strong>{{ $apartment->title_desc }}</strong></h1>
            <div class="row  d-flex">
                <div class="col-6">
                    <div class="img-box rounded-2 overflow-hidden position-relative">
                        <img class="img-fluid w-100 img-fixed-show"
                            @if (str_starts_with($apartment->img, 'img')) src="{{ asset($apartment->img) }}" @elseif (str_starts_with($apartment->img, 'uploads')) src="{{ asset('storage/' . $apartment->img) }}"  @else src="https://placehold.co/600x400" @endif
                            alt="">
                        @if (!empty($sponsor))
                            @php
                                $created_dates = [];
                                foreach ($sponsor as $sponsor_first) {
                                    array_push($created_dates, $sponsor_first['pivot']['created']);
                                }
                                array_multisort($created_dates, SORT_ASC, $sponsor);
                                $stop = false;
                            @endphp
                            @foreach ($sponsor as $sponsor_first)
                                @if ($sponsor_first['pivot']['expiry'] > date('Y-m-d H:i:s') && $stop == false)
                                    <div @class([
                                        'sponsor-icon',
                                        'standard-text' => $sponsor_first['id'] == 1,
                                        'gold-text' => $sponsor_first['id'] == 2,
                                        'platinum-text' => $sponsor_first['id'] == 3,
                                    ])>
                                        <i class="fa-solid fa-crown fs-2"></i>
                                    </div>
                                    @php $stop = true; @endphp
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-6">
                    <div class="desc-box d-flex flex-column justify-content-between h-100">
                        <div>
                            <div @class([
                                'd-flex',
                                'justify-content-between' => $sponsor,
                                'justify-content-end' => !$sponsor,
                            ])>
                                @if ($sponsor)
                                    <p><strong class="text-color">Scadenza sponsorizzazione:
                                        </strong>{{ $sponsor[0]['pivot']['expiry'] }}</p>
                                @endif
                                <a href="{{ route('admin.apartments.sponsors', $apartment) }}">
                                    <div class="btn btn-warning fw-bold text-light">Sponsorizza</div>
                                </a>
                            </div>

                            <p><strong class="text-color">Indirizzo: </strong>{{ $address[0] }}</p>
                            <ul>
                                <p class="text-color m-0"><strong>Servizi:</strong></p>
                                <div class="row">
                                    
                                    @foreach ($apartment->services as $service)
                                    <div class="col-6">
                                        <li><span class="text-color"><i class="fa-solid fa-{{ $service->logo }}"></i>
                                        </span>{{ $service->name }}</li>
                                    </div>
                                    @endforeach
                                </div>
                            </ul>
                            <table class="table text-center mt-2">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <p class="text-color m-0">Stanze</p>
                                        </th>
                                        <th scope="col">
                                            <p class="text-color m-0">Bagni</p>
                                        </th>
                                        <th scope="col">
                                            <p class="text-color m-0">Letti</p>
                                        </th>
                                        <th scope="col">
                                            <p class="text-color m-0">Mt²</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $apartment->n_rooms }}</td>
                                        <td>{{ $apartment->n_bathrooms }}</td>
                                        <td>{{ $apartment->n_beds }}</td>
                                        <td>{{ $apartment->square_mts }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-auto mb-2 d-flex justify-content-between">
                            <div class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#message-{{ $apartment->id }}-apartment">
                                Messaggi
                            </div>
                            <div>
                                <a href="{{ route('admin.apartments.edit', $apartment) }}">
                                    <div class="btn btn-success"> <i class="fa-solid fa-pencil"></i> Modifica</div>
                                </a>
                                <div class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete-{{ $apartment->id }}-apartment">
                                    <i class="fa-solid fa-trash"></i> Elimina
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($apartment->visible)
            <div class="d-flex align-items-center pt-2 gap-2">
                <i class="eye fa-solid fa-eye fs-4"></i>
                <span class="fs-5">L'appartamento è visibile</span>
            </div>
            @else
            <div class="d-flex align-items-center pt-2 gap-2">
                <i class="eye fa-solid fa-eye-slash fs-4"></i>
                <span class="fs-5">L'appartamento non è visibile</span>
            </div>
            @endif
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="delete-{{ $apartment->id }}-apartment" tabindex="-1"
        aria-labelledby="delete-{{ $apartment->id }}-apartment" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="delete-{{ $apartment->id }}-apartment">
                        Eliminare {{ $apartment->title_desc }} ?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Se confermi non potrai tornare indietro.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>

                    <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Elimina</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal-msg')
    <div class="modal fade modal-dialog-scrollable" id="message-{{ $apartment->id }}-apartment" tabindex="-1"
        aria-labelledby="message-{{ $apartment->id }}-apartment" aria-hidden="true">
        <div class="modal-dialog" style="max-width:1000px">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold" id="message-{{ $apartment }}-apartment">
                        Messaggi per {{ $apartment->title_desc }} </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">Corpo</div>
                        <div class="col-3">Email</div>
                        <div class="col">Ricevuto il</div>
                        <div class="col-1"></div>
                    </div>
                    @forelse ($messages as $message)
                        <div class="row border align-items-center email-line">
                            <div class="col-6">{{ $message->getAbstract(50) }}</div>
                            <div class="col-3">{{ $message->email }}</div>
                            <div class="col">{{ $message->getDate() }}</div>
                            <div class="col-1">
                                <a href="{{ route('admin.messages.show', ['apartment' => $apartment, 'message' => $message]) }}">
                                    <i class="fa-solid fa-circle-info text-primary"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="row border">
                            <div class="col">Nessun Messaggio Ricevuto</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
