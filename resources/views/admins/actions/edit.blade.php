@php use Illuminate\Support\Str; @endphp
@extends('admins.layouts.app')

@section('title', "Action " . $action->name)

@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1 class="h3 mb-2 text-gray-800">Action {{ $action->name }}</h1>
            <div>
                <a href="{{ route('admin.actions.content.create', $action) }}" class="btn btn-sm btn-primary">Ajouter un
                    contenu</a>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Type</th>
                            <th scope="col">Clé</th>
                            <th scope="col">Description</th>
                            <th scope="col">Valeur par défaut</th>
                            <th scope="col">Crée le</th>
                            <th scope="col" style="width: 100px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($action->contents as $content)
                            <tr>
                                <td>{{ $content->id }}</td>
                                <td>{{ $content->data_type }}</td>
                                <td>{{ $content->key }}</td>
                                <td>{{ Str::limit($content->description, 50) }}</td>
                                <td>{{ $content->value ?? '-' }}</td>
                                <td>{{ format_date($content->created_at) }}</td>
                                <td class="d-flex align-items-center" style="width: 100%">
                                    <div class="me-1" style="margin-right: 10px;">
                                        <a href="{{ route('admin.actions.content.edit', $content) }}"><i
                                                class="fas fa-edit"></i></a>
                                    </div>
                                    <form action="{{ route('admin.actions.content.destroy', $content) }}"
                                          method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">

                <form action="{{ route('admin.actions.update', $action->id) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $action->name }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"
                                  rows="5">{{ $action->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="example">Exemple</label>
                        <textarea class="form-control" id="example" name="example"
                                  rows="10">{{ $action->example }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="documentation_url">URL de la Documentation</label>
                        <input type="url" class="form-control" id="documentation_url" name="documentation_url" value="{{ $action->documentation_url }}">
                    </div>

                    <div class="form-group">
                        <label for="addon_id">Addon</label>
                        <select class="form-control" id="addon_id" name="addon_id" required>
                            @foreach($addons as $addon)
                                <option value="{{ $addon->id }}" {{ $action->addon_id == $addon->id ? 'selected' : '' }}>{{ $addon->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="is_zmenu_plus" name="is_zmenu_plus" value="1" {{ $action->is_zmenu_plus ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_zmenu_plus">zMenu+</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>

            </div>
        </div>

    </div>

@endsection
