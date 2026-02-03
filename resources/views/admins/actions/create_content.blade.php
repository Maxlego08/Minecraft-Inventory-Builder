@extends('admins.layouts.app')

@section('title', 'Créer un nouveau contenu')

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Créer un contenu pour l'action {{ $action->name }}</h1>

        <div class="card shadow mb-4">
            <div class="card-body">

                <form action="{{ route('admin.actions.content.store', $action) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="data_type">Type de Donnée</label>
                        <select class="form-control" id="data_type" name="data_type" required>
                            <option value="string">String</option>
                            <option value="textarea">Textarea</option>
                            <option value="bool">Bool</option>
                            <option value="integer">Integer</option>
                            <option value="float">Float</option>
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
                        <label for="value">Valeur par défaut</label>
                        <input type="text" class="form-control" id="value" name="value">
                    </div>

                    <button type="submit" class="btn btn-success">Créer</button>
                </form>

            </div>
        </div>
    </div>

@endsection
