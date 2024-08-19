@extends('admins.layouts.app')

@section('title', "Button " . $button->name)

@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <h1 class="h3 mb-2 text-gray-800">Bouton {{ $button->name }}</h1>
            <div>
                <a href="{{ route('admin.buttons.content.create', $button) }}" class="btn btn-sm btn-primary">Ajouter un
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
                            <th scope="col">URL de Documentation</th>
                            <th scope="col">Crée le</th>
                            <th scope="col" style="width: 100px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($button->contents as $content)
                            <tr>
                                <td>{{ $content->id }}</td>
                                <td>{{ $content->data_type }}</td>
                                <td>{{ $content->key }}</td>
                                <td>{{ Str::limit($content->description, 50) }}</td>
                                <td>{{ Str::limit($content->documentation_url, 50) }}</td>
                                <td>{{ format_date($content->created_at) }}</td>
                                <td class="d-flex align-items-center" style="width: 100%">
                                    <div class="me-1" style="margin-right: 10px;">
                                        <a href="{{ route('admin.buttons.content.edit', $content) }}"><i
                                                class="fas fa-edit"></i></a>
                                    </div>
                                    <form action="{{ route('admin.buttons.content.destroy', $content) }}"
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

                <form action="{{ route('admin.buttons.update', $button->id) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $button->name }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"
                                  rows="5">{{ $button->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="example">Exemple</label>
                        <textarea class="form-control" id="example" name="example"
                                  rows="10">{{ $button->example }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>

            </div>
        </div>

    </div>

@endsection
