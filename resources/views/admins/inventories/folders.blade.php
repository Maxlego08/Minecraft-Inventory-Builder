@extends('admins.layouts.app')

@section('title', 'Inventaires')

@section('content')
    <!-- Begin Page Content -->

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Dossier {{ $folder->name }}</h1>

        {!! $folder->generate() !!}

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
            </div>
        </div>

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
            </div>
        </div>
    </div>
@endsection
