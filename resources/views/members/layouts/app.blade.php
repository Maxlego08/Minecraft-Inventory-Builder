@extends('layouts.app')

@section('content')

    <div class="content_resources_show py-5 mb-5 members">
        <div class="px-lg-0">
            <div class="container">
                <div class="main-row-2">
                    <div class="main-col-1">
                        <div class="rounded-0 card">
                            <div class="card-header d-flex justify-content-center align-items-center">

                                <img src="{{ user()->getProfilePhotoUrlAttribute() }}" height="50" width="50"
                                     alt="{{ user()->name }}" class="rounded-2">
                                <span class="d-none d-lg-block ms-2">{{ user()->name }}</span>

                            </div>
                            <div class="card-body px-4">
                                <nav>
                                    <ul class="ps-0">
                                        <li class="list-group-item mb-2">
                                            <a href="#">{{ __('Your account') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="#">{{ __('Your Alerts') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="#">{{ __('View conversations') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="#">{{ __('Your Resources') }}</a>
                                        </li>
                                        <li class="list-group-item mb-2">
                                            <a href="#">{{ __('Add resource') }}</a>
                                        </li>
                                    </ul>
                                </nav>

                            </div>
                        </div>

                    </div>
                    <div class="main-col-2">

                        <div class="members-banner">
                            <div class="members-banner-wrapper">
                                <div class="general-info">
                                    <h2 class="general-info-name">Espace membre</h2>
                                </div>
                                <p class="description">Bienvenue dans l'espace pour la gestion de votre compte et de vos
                                    ressources.</p>
                            </div>
                        </div>

                        @yield('content-member')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
