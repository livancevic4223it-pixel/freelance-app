@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Aktivni oglasi</h2>

        <a href="{{ route('jobs.create') }}" class="btn btn-primary">
            Dodaj novi oglas
        </a>
    </div>

    @forelse($jobs as $job)
        <div class="card mb-3 p-3">

            <h5 class="mb-1">{{ $job->title }}</h5>
            <p class="mb-2">{{ $job->description }}</p>
            <small class="text-muted d-block mb-3">
                Budžet: {{ $job->budget }}€
            </small>

            <div class="d-flex justify-content-between align-items-center">
                <!-- DUGME ZA PREGLED -->
                <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary btn-sm">
                    Pregledaj oglas
                </a>

                <!-- OBRIŠI (SAMO VLASNIK) -->
                @if($job->user_id === auth()->id())
                    <form action="{{ route('jobs.destroy', $job) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            Obriši
                        </button>
                    </form>
                @endif
            </div>

        </div>
    @empty
        <p>Nema aktivnih oglasa.</p>
    @endforelse

</div>
@endsection
