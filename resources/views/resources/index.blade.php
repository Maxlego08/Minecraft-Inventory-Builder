@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_resources_add py-5 mb-5">
        <div class="container">
            <div class="px-0 px-lg-0">
                <div class="block_resources_add card my-4 rounded-0">
                    <div class="card-body px-4">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <h1 class="fw-bold fs-3">Ressources</h1>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas egestas nibh at
                                    ante
                                    luctus
                                    convallis.</p>
                            </div>
                            <div class="col-lg-4 offset-lg-1">
                                <a href="{{route('resources.create.index')}}"
                                   class="btn btn-primary btn-sm rounded-0 d-flex align-items-center justify-content-center"><i
                                        class="bi bi-plus-lg me-2 fs-6"></i>AJOUTER UNE RESSOURCE</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-md-6 col-lg-12">
                                <div class="card mb-3 rounded-0">
                                    <div class="card-body">
                                        <h2 class="text-center fs-5 fw-bold">Catégories</h2>
                                        <ul class="list-group">
                                            <li class="d-flex justify-content-between align-items-cente">
                                                Lorem<span>14</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-cente">
                                                Ipsum<span>22</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-cente">
                                                Dolor<span>0</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-cente">
                                                Sit<span>139</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-cente">
                                                Amet<span>6</span></li>
                                            <li class="d-flex justify-content-between align-items-cente">
                                                Consectetur<span>0</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-cente">
                                                Adipscing<span>663</span>
                                            </li>
                                            <li class="d-flex justify-content-between align-items-cente">
                                                Elit<span>19</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-12">
                                <div class="card mb-3 rounded-0">
                                    <div class="card-body">
                                        <h2 class="text-center fs-5 fw-bold">Le plus de ressources</h2>
                                        <ul class="list-group">
                                            <li class="d-flex mb-2">
                                                <a class="img_1"
                                                   href="https://groupez.dev/resources/authors/maxlego08.1"
                                                   title="Maxlego08 profile">
                                                    <img class=""
                                                         src="https://groupez.dev/storage/images/users/0/0/0/1.png"
                                                         alt="Maxlego08" width="50" height="50">
                                                </a>
                                                <div class="ms-3">
                                                    <p class="mb-0 fw-light">Maxlego08</p>
                                                    <span class="text-muted fs-7">107 ressources sur le site</span>
                                                </div>
                                            </li>
                                            <li class="d-flex mb-2">
                                                <a class="img_1" href="https://groupez.dev/resources/zkoth.9"
                                                   title="Show zKoth description">
                                                    <img class="" src="https://groupez.dev/storage/images/9.png"
                                                         alt="zKoth logo" width="50" height="50">
                                                </a>
                                                <div class="ms-3">
                                                    <p class="mb-0 fw-light">Maxlego08</p>
                                                    <span class="text-muted fs-7">107 ressources sur le site</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <h2 class="visually-hidden-focusable">Les ressources</h2>
                        @for ($i = 0; $i < 15; $i++)
                            <div class="block_resources px-2 bg-blue-800 rounded-0 mb-2">
                                <div class="d-flex flex-wrap flex-lg-nowrap">
                                    <div class="block_resources_start me-0 me-lg-3">
                                        <a class="img_1" href="https://groupez.dev/resources/zkoth.9"
                                           title="Show zKoth description">
                                            <img class="" src="https://groupez.dev/storage/images/9.png"
                                                 alt="zKoth logo" width="50" height="50">
                                        </a>
                                        <a class="img_2 position-absolute start-100"
                                           href="https://groupez.dev/resources/authors/maxlego08.1"
                                           title="Maxlego08 profile">
                                            <img src="https://groupez.dev/storage/images/users/0/0/0/1.png"
                                                 alt="Maxlego08 Avatar" width="25" height="25">
                                        </a>
                                    </div>
                                    <div class="block_resources_center ms-2 ms-lg-2">
                                        <h3 class="fw-bold fs-5 mb-0"><a class="link-light text-decoration-none"
                                                                         href="#">zKoth -
                                                Minecraft KOTH Plugin (1.7.10 - 1.19.1)</a>
                                            <span
                                                class="text-muted fw-normal fs-6 ms-2">v2.0.4.2</span></h3>
                                        <span class="text-muted fw-light fs-7">Posté par <span
                                                class="text-danger">Maxlego08</span> le 18/07/2022</span>
                                        <p class="mt-1 mb-0">A King of The Hill plugin that has all the flexibility that
                                            you need!</p>
                                    </div>
                                    <div
                                        class="block_resources_end d-flex align-items-center justify-content-end flex-grow-1 fs-7">
                                        <span class="btn btn-success rounded-1 fw-normal py-0 me-2 me-lg-3">8€</span>
                                        <ul class="navbar-nav">
                                            <li class="py-1">
                                                <span class="text-warning">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-half"></i>
                                                    <i class="bi bi-star"></i>
                                                </span>
                                                <span>43 avis</span></li>
                                            <li class="py-1"><span>Téléchargement</span> <span>4136</span></li>
                                            <li class="py-1"><span>Mise à jour</span> <span>Lundi 18 juillet</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endfor
                        {!! $resources->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
