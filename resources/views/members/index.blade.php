@extends('members.layouts.app')

@section('content-member')
<!--
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
                            <input type="file" onchange="this.form.submit()" name="image"
                                   class="form-control btn btn-primary btn-sm d-block px-4 w-100 my-2 rounded-0"/>
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

                        <li class="">Date de création du compte: <span
                                class="float-end">{{ format_date(user()->created_at) }}</span>
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
    </div>-->


    <div class="card rounded-0 mt-3 mb-3">
        <div class="card-body">
            <h2>{{ __('profiles.avatar.name') }}</h2>
            <div class="members-picture">
                <form method="POST" action="{{ route('profile.picture.update') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="file" onchange="this.form.submit()" name="image"
                           class="form-control btn btn-primary btn-sm d-block px-4 w-100 my-2 rounded-0"/>
                </form>
                <form method="POST" action="{{ route('profile.picture.destroy') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm d-block px-4 w-100 my-2 rounded-0">
                        {{ __('profiles.avatar.delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('members.elements.email')
    @include('members.elements.password')
    @include('members.elements.discord')

@endsection
