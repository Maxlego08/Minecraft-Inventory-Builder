@extends('admins.layouts.app')

@section('title', 'Inventaires')

@section('content')
    <!-- Begin Page Content -->

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Inventaires</h1>

        <form class="form-inline mb-3" action="{{ route('admin.inventories.index') }}" method="GET">
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
                            <th scope="col">Dossier</th>
                            <th scope="col">Nom du fichier</th>
                            <th scope="col">Nom de l'inventaire</th>
                            <th scope="col">Taille de l'inventaire</th>
                            <th scope="col">Nombre de bouton</th>
                            <th scope="col">Date de création</th>
                            <th scope="col">Dernière modification</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($inventories as $inventory)
                            @include('admins.elements.inventory', ['currentInventory' => $inventory])
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $inventories->withQueryString()->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
