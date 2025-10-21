@extends('landing.index')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4>Mot de passe oublié</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email">Adresse e-mail</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Envoyer le lien de réinitialisation</button>
                    </form>

                    @if (session('status'))
                        <div class="alert alert-success mt-3">{{ session('status') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
