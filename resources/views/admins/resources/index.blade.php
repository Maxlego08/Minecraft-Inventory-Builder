@extends('admins.layouts.app')

@section('title', "Resources")

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ressources</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header">
                <form class="form-inline" action="{{ route('admin.resources.index') }}" method="GET">
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 10px"></th>
                            <th style="width: 150px">Auteur</th>
                            <th>Nom</th>
                            <th style="width: 125px;">Version</th>
                            <th style="width: 100px;">Prix</th>
                            <th style="width: 130px;">Total des ventes</th>
                            <th style="width: 100px;">Téléchargements</th>
                            <th style="width: 175px;">Date de publication</th>
                            <th style="width: 125px;">Status</th>
                            <th style="width: 100px;"></th>
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
                                <th>
                                    @include('admins.elements.user', ['currentUser' => $resource->user])
                                </th>
                                <th>{{ $resource->name }}</th>
                                <th>{{ $resource->version->version }}</th>
                                <th style="@if(!$resource->price == 0) color: rgb(72, 187, 156); @else color: rgb(0, 0, 0); @endif">{{ $resource->price == 0 ? 'Gratuit' : $resource->price . "€" }}</th>
                                <th>ToDo</th>
                                <th>{{ $resource->countDownload() }}</th>
                                <th>{{ format_date($resource->created_at, false) }}</th>
                                <th style="color: {{ $resource->getStatus()['color'] }}">{{ strtoupper(__($resource->getStatus()['message'])) }}</th>
                                <th>
                                    <a href="{{ route('admin.resources.edit', $resource) }}"
                                       class="resource-button-edit"><i class="fa fa-edit"></i></a>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $resources->links('vendor.pagination.bootstrap-4') !!}
            </div>
        </div>
    </div>

@endsection
