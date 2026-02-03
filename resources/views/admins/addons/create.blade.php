@extends('admins.layouts.app')

@section('title', "Créer un addon")

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Créer un addon</h1>

        <div class="card shadow mb-4">
            <div class="card-body">

                <form action="{{ route('admin.addons.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="resource_id">ID de la Ressource</label>
                        <input type="number" class="form-control" id="resource_id" name="resource_id" value="{{ old('resource_id') }}" required>
                        @error('resource_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="is_official" name="is_official" value="1" {{ old('is_official') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_official">Officiel</label>
                    </div>

                    <button type="submit" class="btn btn-success">Créer</button>
                </form>

            </div>
        </div>
    </div>

@endsection
