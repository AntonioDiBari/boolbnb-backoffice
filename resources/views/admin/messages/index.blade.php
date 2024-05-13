{{-- @extends('layouts.app')

@section('content')
    <div class="container my-3">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Body</th>
                    <th scope="col">Sent</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $message)
                    <tr>

                        <td>{{ $message->email }}</td>
                        <td>{{ $message->body }}</td>
                        <td>{{ $message->sent }}</td>

                        <td class="d-flex gap-2">
                            <a href="{{ route('admin.messages.show', $message) }}">
                                <i class="fa-solid fa-circle-info text-primary"></i>
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td>Nessun Messaggio</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $pastas->links('pagination::bootstrap-5') }}
    </div>
@endsection --}}
