@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fs-4 text-secondary my-4">
            {{ __('') }}
        </h2>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card p4-y">

                    <div class="card-body text-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-around py-5">
                <a class="btn btn-outline-success" href="{{ route('admin.apartments.index') }}">Vai ai tuoi appartamenti</a>
                <a class="btn btn-outline-primary" href="{{ route('admin.apartments.create') }}">Aggiungi appartamento</a>
            </div>
        </div>
    </div>
@endsection
