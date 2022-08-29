@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="px-3 px-lg-0">
            <div class="container">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="fw-bold fs-5 mb-0">Se connecter</h1>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas egestas nibh
                            at ante luctus
                            convallis.</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="#" method="POST">
                            @method('POST')
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label for="email" class="form-label ms-3">Adresse e-mail
                                            donation (Facultatif)</label>
                                        <input type="text" class="form-control" id="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label ms-3">Mot de passe</label>
                                        <input type="text" class="form-control" id="password">
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-4 d-block w-100 mt-5">Se
                                        connecter
                                    </button>
                                </div>
                            </div>
                        </form>
                        <a href="#" class="text-muted w-100 text-center my-3 d-block">J’ai oublié mon mot de passe</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
