@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="container">
            <div class="px-3 px-lg-0">
                <div class="card my-4">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-7 col-xl-6 d-flex align-items-center">
                                <div class="block_resources_start">
                                    <a class="img_1" href="https://groupez.dev/resources/zkoth.9"
                                       title="Show zKoth description">
                                        <img class="" src="https://groupez.dev/storage/images/9.png"
                                             alt="zKoth logo">
                                    </a>
                                </div>
                                <div class="ms-4">
                                    <h1 class="fw-bold fs-5 mb-0">zKoth - Minecraft KOTH Plugin (1.7.10 - 1.19.1)</h1>
                                    <p>A King of The Hill plugin that has all the flexibility that you need</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-2 offset-lg-1 offset-xl-3">
                                <a href="{{route('resources.buy',1)}}" class="btn btn-primary w-100 rounded-4">TÉLÉCHARGER<span
                                        class="fs-7 fw-light d-block">809.6 KB .jar</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-9">
                        <ul class="nav nav-tabs justify-content-between flex-nowrap" id="myTabResources" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab"
                                        data-bs-target="#overview-tab-pane" type="button" role="tab"
                                        aria-controls="home-tab-pane" aria-selected="true">Aperçu
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="update-tab" data-bs-toggle="tab"
                                        data-bs-target="#update-tab-pane" type="button" role="tab"
                                        aria-controls="update-tab-pane" aria-selected="false">Mise à jour (43)
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="notice-tab" data-bs-toggle="tab"
                                        data-bs-target="#notice-tab-pane" type="button" role="tab"
                                        aria-controls="notice-tab-pane" aria-selected="false">Avis (17)
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="history-tab" data-bs-toggle="tab"
                                        data-bs-target="#history-tab-pane" type="button" role="tab"
                                        aria-controls="history-tab-pane" aria-selected="false">Historique
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="discussions-tab" data-bs-toggle="tab"
                                        data-bs-target="#discussions-tab-pane" type="button" role="tab"
                                        aria-controls="discussions-tab-pane" aria-selected="false">Discussions
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="buyers-tab" data-bs-toggle="tab"
                                        data-bs-target="#buyers-tab-pane" type="button" role="tab"
                                        aria-controls="buyers-tab-pane" aria-selected="false">Acheteurs
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade bg-blue-800 p-4 show active" id="overview-tab-pane" role="tabpanel"
                                 aria-labelledby="overview-tab" tabindex="0">
                                @include('resources.pages.overview')
                            </div>
                            <div class="tab-pane fade" id="update-tab-pane" role="tabpanel"
                                 aria-labelledby="update-tab" tabindex="0">
                                @include('resources.pages.update')
                            </div>
                            <div class="tab-pane fade" id="notice-tab-pane" role="tabpanel"
                                 aria-labelledby="notice-tab" tabindex="0">
                                @include('resources.pages.notice')
                            </div>
                            <div class="tab-pane fade" id="history-tab-pane" role="tabpanel"
                                 aria-labelledby="history-tab" tabindex="0">
                                @include('resources.pages.history')
                            </div>
                            <div class="tab-pane fade" id="discussions-tab-pane" role="tabpanel"
                                 aria-labelledby="discussions-tab" tabindex="0">
                                @include('resources.pages.discussions')
                            </div>
                            <div class="tab-pane fade" id="buyers-tab-pane" role="tabpanel"
                                 aria-labelledby="buyers-tab" tabindex="0">
                                @include('resources.pages.buyers')
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
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
                                            <span class="text-warning">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                                <i class="bi bi-star"></i>
                                            </span>
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
                                            <span class="text-warning">
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </span>
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
                                <a href="{{route('resources.edit', 1)}}" class="text-decoration-none d-block">Modifier ma ressource</a>
                                <a href="#" class="text-decoration-none d-block">Modifier l’image de ma ressource</a>
                                <a href="{{route('resources.update-ressource',1)}}" class="text-decoration-none d-block">Poster une mise à jour</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
