@extends('admins.layouts.app')

@section('title', 'Code Cadeau')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Code cadeau</h1>

        <div class="d-flex justify-content-between">
            <form class="form-inline mb-3" action="{{ route('admin.gift.index') }}" method="GET">
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
            <div>
                <a href="{{ route('admin.gift.create') }}" class="btn btn-sm btn-success">Créer un code cadeau</a>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Code</th>
                            <th>Réduction</th>
                            <th>Utilisations Maximales</th>
                            <th>Utilisations Actuelles</th>
                            <th>Type</th>
                            <th>Contenu</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <thead>
                        @foreach ($gifts as $gift)
                            <tr>
                                <td>
                                    @include('admins.elements.user', ['currentUser' => $gift->user])
                                </td>
                                <td>{{ $gift->code }}</td>
                                <td>{{ $gift->reduction }}%</td>
                                <td>{{ $gift->max_use }}</td>
                                <td>{{ $gift->used }}</td>
                                <td>{{ $gift->giftable_type }}</td>
                                <td>{!! $gift->getContentName() !!}</td>
                                <td style="color: {{ $gift->active ? 'green' : 'red' }}">{{ $gift->active ? 'Actif' : 'Inactif' }}</td>
                                <td>
                                    <a href="{{ route('admin.gift.edit', $gift) }}"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('admin.gift.delete', $gift) }}"
                                       class="mx-1"
                                       onclick="return confirm('Voulez vous vraiment supprimer le code cadeau.')"
                                       title="Supprimer le serveur" data-toggle="tooltip"><i class="fas fa-trash"
                                                                                             style="color: red"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </thead>
                    </table>
                </div>
                {{ $gifts->withQueryString()->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
