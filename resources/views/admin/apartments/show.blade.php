@extends('layouts.app')
@section('title', 'Dettaglio appartamenti')

@section('content')
    <div class="container my-3">
        <div class="detail-box d-flex flex-column justify-content-center">
            <h1 class="fs-3 text-color"><strong>{{ $apartment->title_desc }}</strong></h1>
            <div class="row  d-flex">
                <div class="col-6">
                    <div class="img-box rounded-2 overflow-hidden">
                        <img class="img-fluid" src="https://picsum.photos/800/650" alt="">
                    </div>
                </div>
                <div class="col-6">
                    <div class="desc-box d-flex flex-column">
                        <div>
                            <p><strong class="text-color">Indirizzo: </strong>{{ $address[0] }}</p>
                            <ul>
                                <p class="text-color m-0"><strong>Servizi:</strong></p>
                                @foreach ($apartment->services as $service)
                                <li><span class="text-color">{!! $service->logo !!} </span>{{ $service->name }}</li>
                                @endforeach
                            </ul>
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th scope="col"><p class="text-color m-0">Stanze</p></th>
                                        <th scope="col"><p class="text-color m-0">Bagni</p></th>
                                        <th scope="col"><p class="text-color m-0">Letti</p></th>
                                        <th scope="col"><p class="text-color m-0">Mt²</p></th>
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
                            <div>
                                <a href="">
                                    <button class="btn btn-primary">Messaggi</button>
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('admin.apartments.edit', $apartment) }}">
                                    <div class="btn btn-success"> <i class="fa-solid fa-pencil"></i> Modifica</div>
                                </a>
                                <div class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-{{ $apartment->id }}-apartment">
                                    <i class="fa-solid fa-trash"></i> Elimina
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection