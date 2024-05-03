@extends('layouts.app')

@section('js')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        function getAddress() {
            axios.get(
                'https://api.tomtom.com/search/2/reverseGeocode/44.06404,12.5724.json?key=J3iuAWIFiXr0BqrC4gh2RHMmzjR7mdUt'
            ).then((response) => {
                console.log(response.data.addresses)
            })
        };
        console.log(getAddress());
    </script>
@endsection

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
                    <th scope="col">Latitudine</th>
                    <th scope="col">Longitudine</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($apartments as $apartment)
                    <tr>
                        <td>{{ $apartment->title_desc }}</td>
                        <td>{{ $apartment->n_rooms }}</td>
                        <td>{{ $apartment->n_bathrooms }}</td>
                        <td>{{ $apartment->n_beds }}</td>
                        <td>{{ $apartment->square_mts }}</td>
                        <td>{{ $apartment->img }}</td>
                        <td>{{ $apartment->visible }}</td>
                        <td>{{ $apartment->latitude }}</td>
                        <td>{{ $apartment->longitude }}</td>
                        {{-- <td>{{ $this->getAddress() }}</td> --}}
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
