@extends('admins.layouts.app')

@section('title', 'Inventaires')

@section('content')
    <!-- Begin Page Content -->

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Dossiers</h1>

        <form class="form-inline mb-3" action="{{ route('admin.inventories.folders.index') }}" method="GET">
            <div class="form-group mb-2">
                <label for="searchInput" class="sr-only">Recherche</label>

                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" name="search" value="{{ $search ?? '' }}"
                           placeholder="Rechercher">

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Utilisateur</th>
                            <th scope="col">Nom du dossier</th>
                            <th scope="col">Nombre de sous dossiers</th>
                            <th scope="col">Nombre d'inventaires</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($folders as $folder)
                            @include('admins.elements.folder', ['currentFolder' => $folder])
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $folders->withQueryString()->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
