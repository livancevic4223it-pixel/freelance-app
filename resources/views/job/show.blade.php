@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">

        <!-- LEVO: DETALJI OGLASA -->
        <div class="col-md-6">
            <h3 class="mb-4">Pregled Oglasa</h3>

            <p><strong>Naziv:</strong> {{ $job->title }}</p>
            <p><strong>Budžet:</strong> {{ $job->budget }}€</p>

            <p class="mt-3"><strong>Opis:</strong></p>
            <p>{{ $job->description }}</p>
        </div>

        <!-- DESNO: FORMA ZA PRIJAVU (DUMMY) -->
        <div class="col-md-6">
            <h3 class="mb-4">Pošalji Prijavu</h3>

            <form>
                <div class="mb-3">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Ime i Prezime"
                    >
                </div>

                <div class="mb-3">
                    <textarea
                        class="form-control"
                        rows="4"
                        placeholder="Poruka"
                    ></textarea>
                </div>

                <button type="button" class="btn btn-success">
                    Posalji Prijavu
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
