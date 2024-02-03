@extends('admins.layouts.app')

@section('title', 'Utilisateurs')

@section('content')
    <!-- Begin Page Content -->

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Utilisateurs</h1>

        <form class="form-inline mb-3" action="{{ route('admin.users.index') }}" method="GET">
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
                            <th scope="col" style="width: 100px">#</th>
                            <th scope="col" style="width: 200px">Pseudo</th>
                            <th scope="col" style="width: 118px; text-align: center">Double auth</th>
                            <th scope="col" style="width: 200px">Email</th>
                            <th scope="col" style="width: 132px; text-align: center">Email vérifié</th>
                            <th scope="col">Role</th>
                            <th scope="col">Discord</th>
                            <th scope="col">Inscrit le</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($users as $user)
                            <tr>
                                <th scope="row">
                                    <a href="{{ route('admin.users.show', ['user' => $user]) }}" class="mx-1"
                                       title="Modifier l'utilisateur" data-toggle="tooltip">
                                        <img style="border-radius: 3px" height="30" width="30"
                                             src="{{ $user->getProfilePhotoUrlAttribute() }}"
                                             alt="Image du joueur {{ $user->name }}">
                                    </a>

                                    @if($user->role->isAdmin())
                                        <i class="fas fa-crown text-warning"
                                           title="L'utilisateur est administrateur du site" data-toggle="tooltip"></i>
                                    @endif
                                    @if($user->role->isBanned())
                                        <i class="fas fa-ban text-danger"
                                           title="L'utilisateur est bannis du site" data-toggle="tooltip"></i>
                                    @endif
                                </th>
                                <td @if($user->role->isBanned())style="color: rgba(0, 0, 0, 0.2)"@endif>
                                    {!! $user->displayName(false)!!}
                                </td>
                                <th>
                                    <div class="d-flex justify-content-center">
                                        @if ($user->two_factor_confirmed_at)
                                            <i class="text-success fas fa-check"></i>
                                        @else
                                            <i class="text-danger fas fa-times"></i>
                                        @endif
                                    </div>
                                </th>
                                <td @if($user->role->isBanned())style="color: rgba(0, 0, 0, 0.2)"@endif> {{ $user->email }} </td>
                                <th>
                                    <div class="d-flex justify-content-center">
                                        @if ($user->email_verified_at)
                                            <i class="text-success fas fa-check"></i>
                                        @else
                                            <i class="text-danger fas fa-times"></i>
                                        @endif
                                    </div>
                                </th>
                                <td @if($user->role->isBanned())style="color: rgba(0, 0, 0, 0.2)"@endif> {{ $user->role->name }} </td>
                                <td @if($user->role->isBanned())style="color: rgba(0, 0, 0, 0.2)"@endif> {{ $user->discord?->username ?? '' }} </td>
                                <td @if($user->role->isBanned())style="color: rgba(0, 0, 0, 0.2)"@endif>
                                    {{ format_date($user->created_at) }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.show', ['user' => $user]) }}" class="mx-1"
                                       title="Edit user" data-toggle="tooltip"><i
                                            class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                {{ $users->withQueryString()->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
