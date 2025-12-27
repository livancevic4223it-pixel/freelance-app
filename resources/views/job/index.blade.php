@extends('layouts.app')

@section('content')
<h2>Aktivni oglasi</h2>

<a href="{{ route('jobs.create') }}" class="btn btn-primary mb-3">Dodaj novi oglas</a>

@foreach($jobs as $job)
    <div class="card mb-2 p-3">
        <h5>{{ $job->title }}</h5>
        <p>{{ $job->description }}</p>
        <small>Budžet: {{ $job->budget }}€</small>

        @if($job->user_id === auth()->id())
            <form action="{{ route('jobs.destroy', $job) }}" method="POST" class="mt-2">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Obriši</button>
            </form>
        @endif
    </div>
@endforeach
@endsection
