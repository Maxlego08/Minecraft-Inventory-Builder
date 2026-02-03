@php use Illuminate\Support\Str; @endphp
@extends('admins.layouts.app')

@section('title', 'Addons')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0 text-gray-800">Addons</h1>
            <a href="{{ route('admin.addons.create') }}" class="btn btn-sm btn-success">Créer un addon</a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Description</th>
                            <th scope="col">Ressource</th>
                            <th scope="col">Officiel</th>
                            <th scope="col">Boutons</th>
                            <th scope="col">Actions</th>
                            <th scope="col">Date de création</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($addons as $addon)
                            <tr>
                                <td>{{ $addon->id }}</td>
                                <td>{{ $addon->name }}</td>
                                <td>{{ Str::limit($addon->description, 50) }}</td>
                                <td>
                                    @if($addon->resource)
                                        <a href="{{ route('admin.resources.edit', $addon->resource) }}">{{ $addon->resource->name }}</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{!! $addon->is_official ? '<span class="badge badge-success">Oui</span>' : '<span class="badge badge-secondary">Non</span>' !!}</td>
                                <td>{{ $addon->buttonTypes->count() }}</td>
                                <td>{{ $addon->actionTypes->count() }}</td>
                                <td>{{ format_date($addon->created_at) }}</td>
                                <td>
                                    <a href="{{ route('admin.addons.edit', $addon) }}"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $addons->withQueryString()->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
