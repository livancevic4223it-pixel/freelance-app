@extends('layouts.app')

@section('content')
<h2>Dodaj kategoriju</h2>

<form method="POST" action="{{ route('categories.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Naziv kategorije</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">
        Dodaj kategoriju
    </button>
</form>
@endsection
