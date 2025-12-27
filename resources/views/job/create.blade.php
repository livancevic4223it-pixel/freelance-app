@extends('layouts.app')

@section('content')
<h2>Dodaj novi oglas</h2>

<form method="POST" action="{{ route('jobs.store') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Naziv oglasa</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Opis</label>
        <textarea name="description" class="form-control" rows="4" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Budžet</label>
        <input type="number" name="budget" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Kategorija</label>
        <select name="category_id" class="form-control" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">Sačuvaj oglas</button>
</form>
@endsection
