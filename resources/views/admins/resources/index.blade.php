@extends('admins.layouts.app')

@section('title', "Resources")

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ressources</h1>
        </div>

        <div style="display: flex; justify-content: space-between">
            <form class="form-inline mb-3" action="{{ route('admin.resources.index') }}" method="GET">
                <div class="form-group mb-2">
                    <label for="searchInput" class="sr-only">Recherche</label>

                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" name="search"
                               value="{{ $search ?? '' }}"
                               placeholder="Rechercher">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>


        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 10px"></th>
                            <th>Nom</th>
                            <th style="width: 150px">Auteur</th>
                            <th style="width: 150px;">Version</th>
                            <th style="width: 100px;">Categorie</th>
                            <th style="width: 100px;">Prix</th>
                            <th style="width: 130px;">Total des ventes</th>
                            <th style="width: 130px;">Téléchargements</th>
                            <th style="width: 200px;">Date de publication</th>
                            <th style="width: 150px;">Status</th>
                            <th style="width: 250px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($resources as $resource)
                            <tr>
                                <th>
                                    <a href="{{ route('resources.view', ['resource' => $resource, 'slug' => $resource->slug()]) }}">
                                        <img style="border-radius: 3px" width="40" height="40"
                                             src="{{ $resource->icon->getPath() }}"
                                             alt="Icon de la resource {{ $resource->id }}">
                                    </a>
                                </th>
                                <th>{{ $resource->name }}</th>
                                <th><a href="{{ route('admin.users.show', ['user' => $resource->user ]) }}">{{ $resource->user->name }}</a></th>
                                <th>{{ $resource->version->version }}</th>
                                <th>{{ $resource->category->name }}</th>
                                <th style="@if(!$resource->price == 0) color: rgb(72, 187, 156); @else color: rgb(0, 0, 0); @endif">{{ $resource->price == 0 ? 'Gratuit' : $resource->price . "€" }}</th>
                                <th>ToDo</th>
                                <th>{{ $resource->countDownload() }}</th>
                                <th>{{ format_date($resource->created_at, true) }}</th>
                                <th>

                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
