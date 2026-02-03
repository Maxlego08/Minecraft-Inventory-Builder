@extends('admins.layouts.app')

@section('title', "Créer un type d'action")

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Créer un type d'action</h1>

        <div class="card shadow mb-4">
            <div class="card-body">

                <form action="{{ route('admin.actions.store') }}" method="POST">
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
                        <label for="example">Exemple</label>
                        <textarea class="form-control" id="example" name="example" rows="10">{{ old('example') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="documentation_url">URL de la Documentation</label>
                        <input type="url" class="form-control" id="documentation_url" name="documentation_url" value="{{ old('documentation_url') }}">
                    </div>

                    <div class="form-group">
                        <label for="addon_id">Addon</label>
                        <select class="form-control" id="addon_id" name="addon_id" required>
                            @foreach($addons as $addon)
                                <option value="{{ $addon->id }}" {{ old('addon_id') == $addon->id ? 'selected' : '' }}>{{ $addon->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="is_zmenu_plus" name="is_zmenu_plus" value="1" {{ old('is_zmenu_plus') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_zmenu_plus">zMenu+</label>
                    </div>

                    <button type="submit" class="btn btn-success">Créer</button>
                </form>

            </div>
        </div>
    </div>

@endsection
