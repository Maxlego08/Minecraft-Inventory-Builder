@extends("admins.layouts.app")

@section ('title',  'Nos Videos')

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Nos vidéos</h1>
        <div class="d-flex justify-content-between">
            <form class="form-inline mb-3" action="{{ route('admin.videos.index') }}" method="GET">
                <div class="form-group mb-2">
                    <label for="searchInput" class="sr-only">Recherche</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" name="search"
                               value="{{ $search ?? '' }}"
                               placeholder="Rechercher">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div>
                <a href="{{ route('admin.videos.create') }}" class="btn btn-sm btn-success">Ajouter une video</a>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Dates de création</th>
                            <th>Lien vers la vidéo</th>
                        </tr>
                        </thead>

                        <thead>
                        @foreach ($videos as $video)
                            <tr>
                                <td>{{ $video->create}}</td>
                                <td> {{$video->url}}</td>
                                <td>
                                    <a href="{{ route('admin.videos.delete', $video) }}"
                                       class="mx-1"
                                       onclick="return confirm('Voulez vous vraiment supprimer la vidéo.')"
                                       title="Supprimer la vidéo" data-toggle="tooltip"><i class="fas fa-trash"
                                                                                           style="color: red"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </thead>

                    </table>
                </div>
                {{ $videos->withQueryString()->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>

    </div>
@endsection
