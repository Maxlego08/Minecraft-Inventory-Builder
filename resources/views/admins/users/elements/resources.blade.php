<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Resources</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col" style="width: 25px">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($resources as $resource)
                            <tr>
                                <th>
                                    <a href="{{ route('resources.view', ['resource' => $resource, 'slug' => $resource->slug()]) }}">
                                    <img style="border-radius: 3px" width="40" height="40"
                                         src="{{ $resource->icon->getPath() }}"
                                         alt="Icon de la resource {{ $resource->id }}">
                                    </a>
                                </th>
                                <th>{{ $resource->name }}</th>
                                <th>{{ format_date($resource->created_at) }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $resources->withQueryString()->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>
