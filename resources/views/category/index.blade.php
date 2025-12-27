@extends('layouts.app')

@section('content')
<h2>Kategorije</h2>

<a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">
    Dodaj novu kategoriju
</a>

@if($categories->isEmpty())
    <p>Nema kategorija.</p>
@else
    <ul class="list-group">
        @foreach($categories as $category)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $category->name }}

                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Obriši</button>
                </form>
            </li>
        @endforeach
    </ul>
@endif
@endsection
