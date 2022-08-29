@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="px-3 px-lg-0">
            <div class="container">
                <div class="card my-4">
                    <div class="card-body px-4">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <h1 class="fw-bold fs-3">Mon profil</h1>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas egestas nibh at
                                    ante luctus convallis.</p>
                            </div>
                            <div class="col-lg-4 offset-lg-1">
                                <a href="#"
                                   class="btn btn-danger btn-sm rounded-4 d-flex align-items-center justify-content-center">Se
                                    déconnecter</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3 mb-5">
                    <div class="card-body p-lg-5">
                        <div class="row justify-content-between">
                            <div class="col-lg-6 d-flex">
                                <img src="https://i.pravatar.cc/150" width="150" height="150" class="rounded-circle"
                                     alt="">
                                <div class="ms-4">
                                    <h3 class="fw-bold">Utilisateur</h3>
                                    <button type="submit" class="btn btn-primary btn-sm d-block px-4 w-100 my-2">
                                        Téléverser une photo
                                    </button>
                                    <button type="submit" class="btn btn-danger btn-sm d-block px-4 w-100 my-2">
                                        Supprimer la photo
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group list-unstyled my-4">


                                    <li class="">Date de création du compte: <span class="float-end">6 août 2021</span>
                                    </li>
                                    <li class="">Adresse e-mail actuelle:<span
                                            class="float-end">adresse@company.com</span></li>
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
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h2>Changer d’adresse e-mail</h2>
                                <form action="#" method="POST">
                                    @method('POST')
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label ms-3">Nouvelle adresse e-mail</label>
                                        <input type="text" class="form-control" id="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label ms-3">Votre mot de passe</label>
                                        <input type="text" class="form-control" id="password">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm rounded-4 d-block w-100 mt-2">
                                        Changer
                                        d’adresse e-mail
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h2>Changer de mot de passe</h2>
                                <form action="#" method="POST">
                                    @method('POST')
                                    @csrf
                                    <div class="mb-3">
                                        <label for="password" class="form-label ms-3">Votre mot de passe</label>
                                        <input type="text" class="form-control" id="password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_new" class="form-label ms-3">Nouveau mot de passe</label>
                                        <input type="text" class="form-control" id="password_new">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_new_new" class="form-label ms-3">Confirmation du nouveau
                                            mot de passe</label>
                                        <input type="text" class="form-control" id="password_new_new">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm rounded-4 d-block w-100 mt-2">
                                        Changer
                                        votre mot de passe
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
