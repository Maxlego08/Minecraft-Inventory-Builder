@extends('admins.layouts.app')

@section('title', "Contenu " . $content->key)

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Contenu {{ $content->key }}</h1>

        <div class="card shadow mb-4">
            <div class="card-body">

                <form action="{{ route('admin.actions.content.update', $content) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="data_type">Type de Donnée</label>
                        <select class="form-control" id="data_type" name="data_type" required>
                            <option value="string" {{ $content->data_type === 'string' ? 'selected' : '' }}>String</option>
                            <option value="textarea" {{ $content->data_type === 'textarea' ? 'selected' : '' }}>Textarea</option>
                            <option value="bool" {{ $content->data_type === 'bool' ? 'selected' : '' }}>Bool</option>
                            <option value="integer" {{ $content->data_type === 'integer' ? 'selected' : '' }}>Integer</option>
                            <option value="float" {{ $content->data_type === 'float' ? 'selected' : '' }}>Float</option>
                        </select>
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
                        <label for="value">Valeur par défaut</label>
                        <input type="text" class="form-control" id="value" name="value" value="{{ $content->value }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>

            </div>
        </div>

    </div>

@endsection
