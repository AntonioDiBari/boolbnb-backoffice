@extends('layouts.app')

@section('content')
    <div class="container my-3">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nome Appartamento</th>
                    <th scope="col">N° Stanze</th>
                    <th scope="col">N° Bagni</th>
                    <th scope="col">N° Letti</th>
                    <th scope="col">Metri Quadri</th>
                    <th scope="col">IMG</th>
                    <th scope="col">Pubbliccato</th>
                    <th scope="col">Indirizzo</th>
                    <th scope="col">Servizi</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($apartments as $key=>$apartment)
                    <tr>
                        <td>{{ $apartment->title_desc }}</td>
                        <td>{{ $apartment->n_rooms }}</td>
                        <td>{{ $apartment->n_bathrooms }}</td>
                        <td>{{ $apartment->n_beds }}</td>
                        <td>{{ $apartment->square_mts }}</td>
                        <td>{{ $apartment->img }}</td>
                        <td>{{ $apartment->visible }}</td>
                        <td>{{ $addresses[$key] }}</td>
                        <td>
                            <ul>
                                @foreach ($apartment->services as $service)
                                <li>{{ $service->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('admin.apartments.edit', $apartment) }}">
                                <i class="fa-solid fa-pencil text-primary"></i>
                            </a>
                            <div data-bs-toggle="modal" data-bs-target="#delete-{{ $apartment->id }}-apartment">
                                <i class="fa-solid fa-trash text-danger"></i>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>Nessun Risultato</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('modal')
    @foreach ($apartments as $apartment)
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
    @endforeach
@endsection
