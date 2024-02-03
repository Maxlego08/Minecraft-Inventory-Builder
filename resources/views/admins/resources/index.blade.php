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
                    <table class="table table-striped">
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
                            <th style="width: 100px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($resources as $resource)
                            @include('admins.elements.resources')
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $resources->links('vendor.pagination.bootstrap-4') !!}
            </div>
        </div>
    </div>

@endsection
