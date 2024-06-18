@extends('admins.layouts.app')

@section('title', 'Logs')

@section('content')
    <!-- Begin Page Content -->

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Logs</h1>

        <form class="form-inline mb-3" action="{{ route('admin.logs.index') }}" method="GET">
            <div class="form-group mb-2">
                <label for="searchInput" class="sr-only">Recherche</label>

                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" name="search" value="{{ $search ?? '' }}"
                           placeholder="Rechercher">

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col" style="width: 200px">Utilisateur</th>
                            <th scope="col">Action</th>
                            <th scope="col">Ip V4</th>
                            <th scope="col">Date</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($logs as $log)
                            <tr>
                                <th scope="row">
                                    @include('admins.elements.user', ['currentUser' => $log->user])
                                </th>
                                <td>
                                    <i style="color: {{ $log->color }}" class="{{ $log->icon }}"></i>
                                    {{ $log->action }}
                                    @if ($log->user->newsletter_at)
                                        <div class="mt-2">
                                            <span class="badge badge-info">
                                                {{ $log->newsletter_active ? 'Abonné depuis le' : 'Désabonné le' }} {{ $log->newsletter_at->format('d/m/Y')}}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $log->ipv4 }}</td>
                                <td>{{ format_date_compact($log->created_at) }}</td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                {{ $logs->withQueryString()->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
