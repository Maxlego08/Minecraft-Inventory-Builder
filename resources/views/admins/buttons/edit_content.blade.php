@extends('admins.layouts.app')

@section('title', "Contenu " . $content->key)

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Contenu {{ $content->key }}</h1>

        <div class="card shadow mb-4">
            <div class="card-body">

                <form action="{{ route('admin.buttons.content.update', $content) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="data_type">Type de Donnée</label>
                        <input type="text" class="form-control" id="data_type" name="data_type" value="{{ $content->data_type }}" required>
                    </div>

                    <div class="form-group">
                        <label for="key">Clé</label>
                        <input type="text" class="form-control" id="key" name="key" value="{{ $content->key }}" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $content->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="documentation_url">URL de la Documentation</label>
                        <input type="url" class="form-control" id="documentation_url" name="documentation_url" value="{{ $content->documentation_url }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>

            </div>
        </div>

    </div>

@endsection
