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
                            <th scope="col" style="width: 100px">#</th>
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
                            <tr>
                                <td>{{ $inventory->id }}</td>
                                <td>
                                    @include('admins.elements.user', ['currentUser' => $inventory->user])
                                </td>
                                <td>{{ $inventory->folder->name }}</td>
                                <td>{{ $inventory->file_name }}</td>
                                <td>{{ $inventory->name ?? 'Inventory' }}</td>
                                <td>{{ $inventory->size }}</td>
                                <td>{{ $inventory->buttons->count() }}</td>
                                <td>{{ format_date($inventory->created_at, true) }}</td>
                                <td>{{ format_date($inventory->updated_at, true) }}</td>
                                <td>
                                    <a href="{{ route('builder.edit', $inventory) }}" target="_blank"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                {{ $inventories->withQueryString()->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
