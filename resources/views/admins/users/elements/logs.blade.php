<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Logs</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col" style="width: 25px">#</th>
                        <th scope="col">Utilisateur</th>
                        <th scope="col">Action</th>
                        <th scope="col">Ip V4</th>
                        <th scope="col">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <th scope="row">
                                <img style="width: 30px; height: 30px; border-radius: 3px"
                                     src="{{ $log->user->getProfilePhotoUrlAttribute() }}"
                                     alt="Image de profil de l'utilisateur {{ $log->user->name }}">
                            </th>
                            <td>{{ $log->user->name }}</td>
                            <td>
                                <i style="color: {{ $log->color }}" class="{{ $log->icon }}"></i>
                                {{ $log->action }}
                            </td>
                            <td>{{ $log->ipv4 }}</td>
                            <td>{{ format_date_compact($log->created_at) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $logs->withQueryString()->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</div>
