@php use Illuminate\Support\Str; @endphp
@extends('admins.layouts.app')

@section('title', 'Boutons')

@section('content')
    <!-- Begin Page Content -->

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Boutons</h1>

        <form class="form-inline mb-3" action="{{ route('admin.buttons.index') }}" method="GET">
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
                            <th scope="col">Pseudo</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Contenu</th>
                            <th scope="col">Addon</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($buttons as $button)
                            <tr>
                                <td>{{ $button->id }}</td>
                                <td>
                                    @include('admins.elements.user', ['currentUser' => $button->addon->resource->user])
                                </td>
                                <td>{{ $button->name }}</td>
                                <td>{{ count($button->contents) }}</td>
                                <td>{{ $button->addon->name }}</td>
                                <td>
                                    <a href="{{ route('admin.buttons.edit', $button) }}"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $buttons->withQueryString()->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
