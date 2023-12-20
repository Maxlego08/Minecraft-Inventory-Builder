@extends('admins.layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h4 mb-2 text-gray-800">Edition de l'utilisateur {!! $user->displayName(false) !!}
            <img style="border-radius: 3px" height="30" width="30"
                 src="{{ $user->getProfilePhotoUrlAttribute() }}"
                 alt="Image du joueur {{ $user->name }}">
        </h1>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form action="{{ route('admin.users.store', ['user' => $user]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nameInput">Pseudo</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="nameInput" name="name" value="{{ old('name', $user->name) }}"
                                               required>
                                        @error('name')
                                        <span class="invalid-feedback"
                                              role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emailInput">Email</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                               id="emailInput" name="email" value="{{ old('email', $user->email) }}"
                                               required>
                                        @error('email')
                                        <span class="invalid-feedback"
                                              role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="passwordInput">Mot de passe</label>
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               id="passwordInput" name="new-password" placeholder="**********"
                                        >
                                        @error('password')
                                        <span class="invalid-feedback"
                                              role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_role_id">Grade</label>
                                        <select class="custom-select @error('user_role_id') is-invalid @enderror"
                                                id="user_role_id" name="user_role_id">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}"
                                                        @if($user->user_role_id == $role->id) selected @endif>{{ $role->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('role')
                                        <span class="invalid-feedback"
                                              role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name_color_id">Couleur du pseudo</label>
                                        <select class="custom-select @error('name_color_id') is-invalid @enderror"
                                                id="name_color_id" name="name_color">
                                            <option value="-1" selected>Aucune couleur</option>
                                            @foreach($colors as $color)
                                                <option value="{{ $color->id }}"
                                                        @if($user->name_color_id == $color->id) selected @endif>
                                                    {{ $color->translation() }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('name_color_id')
                                        <span class="invalid-feedback"
                                              role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Sauvegarder
                            </button>
                        </form>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-4 d-flex justify-content-between align-items-center">

                            <a href="{{ $user->getProfilePhotoLargeUrlAttribute() }}" target="_blank" class="ms-3">
                                <img style="border-radius: 3px;" width="100" height="100"
                                     src="{{ $user->getProfilePhotoLargeUrlAttribute() }}"
                                     alt="Image du joueur {{ $user->name }}">
                            </a>

                            <form action="{{ route('admin.users.delete.icon', ['user' => $user]) }}"
                                  method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>

                        </div>

                        @if($user->banner_photo_path)
                            <div class="col-md-8 d-flex justify-content-between align-items-center">

                                <a href="{{ $user->getBannerUrlAttribute() }}" target="_blank" class="ms-3">
                                    <img style="border-radius: 3px;" width="600"
                                         src="{{ $user->getBannerUrlAttribute() }}"
                                         alt="Image du joueur {{ $user->name }}">
                                </a>

                                <form action="{{ route('admin.users.delete.banner', ['user' => $user]) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admins.users.elements.resources')
    @include('admins.users.elements.logs')

@endsection
