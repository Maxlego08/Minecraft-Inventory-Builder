@extends('members.layouts.app')

@section('content-member')

    <div class="card rounded-0 mt-3 mb-3">
        <div class="card-body p-lg-5">
            <div class="row justify-content-between">
                <div class="col-lg-6 d-flex">
                    <img src="{{ user()->getProfilePhotoUrlAttribute() }}" width="150" height="150"
                         class="rounded-circle"
                         alt="{{ user()->name }}">
                    <div class="ms-4">
                        <h3 class="fw-bold">{{ user()->name }}</h3>
                        <form method="POST" action="{{ route('profile.picture.update') }}"
                              enctype="multipart/form-data">
                            @csrf
                            <label for="formFile" class="form-label">Téléverser une photo</label>
                            <input type="file" onchange="this.form.submit()" name="image" class="form-control btn btn-primary btn-sm d-block px-4 w-100 my-2 rounded-0"/>
                        </form>
                        <form method="POST" action="{{ route('profile.picture.destroy') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm d-block px-4 w-100 my-2 rounded-0">
                                Supprimer la photo
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="list-group list-unstyled my-4">


                        <li class="">Date de création du compte: <span class="float-end">{{ format_date(user()->created_at) }}</span>
                        </li>
                        <li class="">Adresse e-mail actuelle:<span
                                class="float-end">{{ user()->email }}</span></li>
                        <li class="">Abonnement actuel:<span class="float-end fw-bold">Gratuit</span></li>
                        <li><a href="#" title="Changer d’offre" class="float-end">Changer d’offre</a></li>
                        <li><a href="#" title="Annuler mon abonnement" class="link-danger float-end">Annuler
                                mon abonnement</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card rounded-0 mb-3">
        <div class="card-body">
            <h2>Changer d’adresse e-mail</h2>
            <form action="{{ route('profile.email') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Nouvelle adresse e-mail</label>
                    <input type="email" class="form-control rounded-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ user()->email }}">
                    @error('email')
                    <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-sm rounded-0 d-block w-100 mt-2">
                    Changer d’adresse e-mail
                </button>
            </form>
        </div>
    </div>

    <div class="card rounded-0 mb-3">
        <div class="card-body">
            <h2>Changer de mot de passe</h2>
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="old_password" class="form-label">Votre mot de passe</label>
                    <input type="password" class="form-control rounded-0 @error('old_password') is-invalid @enderror" id="password" name="old_password">
                    @error('old_password')
                    <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Nouveau mot de passe</label>
                    <input type="password" class="form-control rounded-0 @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                    <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmation du nouveau
                        mot de passe</label>
                    <input type="password" class="form-control rounded-0 @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                    @error('password_confirmation')
                    <div id="password-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-sm rounded-0 d-block w-100 mt-2">
                    Changer votre mot de passe
                </button>
            </form>
        </div>
    </div>

@endsection
