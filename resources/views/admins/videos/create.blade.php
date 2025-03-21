@extends('admins.layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('admin.videos.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="url">Liens Videos</label>
                        <div class="input-group mb-2">
                            <input type="url" class="form-control" id="url" name="url" placeholder="URL"
                                   required>
                        </div>
                        <button type="Ajouter" class="btn btn-primary">Ajouter Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
