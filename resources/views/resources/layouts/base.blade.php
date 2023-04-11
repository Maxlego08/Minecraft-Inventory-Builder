@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="container">
            <div class="px-3 px-lg-0">
                <div class="card my-4 rounded-0">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-7 col-xl-9 d-flex align-items-center flex-wrap flex-sm-nowrap">
                                <div class="block_resources_start">
                                    <a class="img_1" href="{{ $resource->link('description') }}"
                                       title="Show {{ $resource->name }} description">
                                        <img class="" src="{{ $resource->icon->getPath() }}"
                                             alt="{{ $resource->name }} logo" width="50" height="50">
                                    </a>
                                </div>
                                <div class="ms-sm-4">
                                    <h1 class="fw-bold fs-5 mb-0">{{ $resource->name }}</h1>
                                    <p>{{ $resource->tag }}</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-2 offset-lg-1">
                                <a href="{{  url('resources.buy') }}" class="btn btn-primary w-100 rounded-4">TÉLÉCHARGER<span
                                        class="fs-7 fw-light d-block">809.6 KB .jar</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-9">
                        <ul class="nav nav-tabs justify-content-lg-between flex-wrap flex-lg-nowrap" id="myTabResources"
                            role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="overview-tab" data-bs-toggle="tab"
                                        data-bs-target="#overview-tab-pane" type="button" role="tab"
                                        aria-controls="home-tab-pane" aria-selected="true">Aperçu
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="update-tab" data-bs-toggle="tab"
                                        data-bs-target="#update-tab-pane" type="button" role="tab"
                                        aria-controls="update-tab-pane" aria-selected="false">Mise à jour (43)
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="notice-tab" data-bs-toggle="tab"
                                        data-bs-target="#notice-tab-pane" type="button" role="tab"
                                        aria-controls="notice-tab-pane" aria-selected="false">Avis (17)
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="history-tab" data-bs-toggle="tab"
                                        data-bs-target="#history-tab-pane" type="button" role="tab"
                                        aria-controls="history-tab-pane" aria-selected="false">Historique
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="discussions-tab" data-bs-toggle="tab"
                                        data-bs-target="#discussions-tab-pane" type="button" role="tab"
                                        aria-controls="discussions-tab-pane" aria-selected="false">Discussions
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="buyers-tab" data-bs-toggle="tab"
                                        data-bs-target="#buyers-tab-pane" type="button" role="tab"
                                        aria-controls="buyers-tab-pane" aria-selected="false">Acheteurs
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="bg-blue-800 p-4 show active">
                                @yield('resource')
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mt-3 mt-lg-0">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="text-center fs-6 fw-bold mb-3">Informations générales</h2>
                                <ul class="list-group">
                                    <li class="d-flex justify-content-between align-items-cente">
                                        Auteur <span class="text-danger">Maxlego08</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-cente">
                                        Téléchargements<span>615</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-cente">
                                        Date de sortie <span>23 déc. 2020</span>
                                    <li class="d-flex justify-content-between align-items-cente">
                                        Dernière MàJ <span>17 jui. 2022</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-cente">
                                        Catégorie<span>Faction</span>
                                    </li>

                                    <li class="d-flex justify-content-between align-items-cente mt-4">
                                        Avis général
                                        <span>
                                            @include('elements.stars')
                                            <br>
                                            <span class="text-muted fst-italic">(17 reviews)</span>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="text-center fs-6 fw-bold mb-3">Version actuelle</h2>
                                <ul class="list-group">
                                    <li class="d-flex justify-content-between align-items-cente">
                                        Version<span>15.356.2</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-cente">
                                        Téléchargements<span>19</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-cente">
                                        Date de sortie <span>17 jui. 2022</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-cente mt-4">
                                        Avis sur la version
                                        <span>
                                            @include('elements.stars')
                                            <br>
                                            <span class="text-muted fst-italic">(0 reviews)</span>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="text-center fs-6 fw-bold mb-3">Gérer votre ressource</h2>
                                <a href="{{ url('resources.edit', 1) }}" class="text-decoration-none d-block">Modifier
                                    ma ressource</a>
                                <a href="#" class="text-decoration-none d-block">Modifier l’image de ma ressource</a>
                                <a href="{{ url('resources.update-ressource', 1) }}"
                                   class="text-decoration-none d-block">Poster une mise à jour</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
