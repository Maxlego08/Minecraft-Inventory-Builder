@extends('admins.layouts.app')

@section('title', 'Créer un nouveau contenu')

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Créer un contenu pour le bouton {{ $button->name }}</h1>

        <div class="card shadow mb-4">
            <div class="card-body">

                <form action="{{ route('admin.buttons.content.store', $button) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="data_type">Type de Donnée</label>
                        <select class="form-control" id="data_type" name="data_type" required>
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="number">Number</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="key">Clé</label>
                        <input type="text" class="form-control" id="key" name="key" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="documentation_url">URL de la Documentation</label>
                        <input type="url" class="form-control" id="documentation_url" name="documentation_url">
                    </div>

                    <button type="submit" class="btn btn-success">Créer</button>
                </form>

            </div>
        </div>
    </div>

@endsection
