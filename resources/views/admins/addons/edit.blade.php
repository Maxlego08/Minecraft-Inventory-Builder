@php use Illuminate\Support\Str; @endphp
@extends('admins.layouts.app')

@section('title', "Addon " . $addon->name)

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Addon {{ $addon->name }}</h1>

        <!-- Button Types -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="mb-0">Boutons ({{ $addon->buttonTypes->count() }})</h5>
            </div>
            <div class="card-body">
                @if($addon->buttonTypes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Contenu</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($addon->buttonTypes as $button)
                                <tr>
                                    <td>{{ $button->id }}</td>
                                    <td>{{ $button->name }}</td>
                                    <td>{{ count($button->contents) }}</td>
                                    <td>
                                        <a href="{{ route('admin.buttons.edit', $button) }}"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">Aucun bouton associé à cet addon.</p>
                @endif
            </div>
        </div>

        <!-- Action Types -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="mb-0">Actions ({{ $addon->actionTypes->count() }})</h5>
            </div>
            <div class="card-body">
                @if($addon->actionTypes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Contenu</th>
                                <th scope="col">zMenu+</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($addon->actionTypes as $action)
                                <tr>
                                    <td>{{ $action->id }}</td>
                                    <td>{{ $action->name }}</td>
                                    <td>{{ count($action->contents) }}</td>
                                    <td>{!! $action->is_zmenu_plus ? '<span class="badge badge-success">Oui</span>' : '<span class="badge badge-secondary">Non</span>' !!}</td>
                                    <td>
                                        <a href="{{ route('admin.actions.edit', $action) }}"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">Aucune action associée à cet addon.</p>
                @endif
            </div>
        </div>

        <!-- Edit Form -->
        <div class="card shadow mb-4">
            <div class="card-body">

                <form action="{{ route('admin.addons.update', $addon->id) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $addon->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5">{{ $addon->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="resource_id">ID de la Ressource</label>
                        <input type="number" class="form-control" id="resource_id" name="resource_id" value="{{ $addon->resource_id }}" required>
                        @if($addon->resource)
                            <small class="form-text text-muted">Ressource actuelle : <a href="{{ route('admin.resources.edit', $addon->resource) }}">{{ $addon->resource->name }}</a></small>
                        @endif
                        @error('resource_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="is_official" name="is_official" value="1" {{ $addon->is_official ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_official">Officiel</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>

            </div>
        </div>

    </div>

@endsection
