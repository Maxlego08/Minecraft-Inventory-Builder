@extends('layouts.base')

@section('title', 'Post Resource Update')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="px-3 px-lg-0">
            <div class="container">
                <div class="card mb-3 rounded-1">
                    <div class="card-body">
                        <h4 class="fw-bold fs-5 mb-0">Faire une mise à jour</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas egestas nibh
                            at ante luctus
                            convallis.</p>
                    </div>
                </div>

                <div class="card rounded-1">
                    <div class="card-body">
                        <form action="#" method="POST">
                            @method('POST')
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <div class="mb-3">
                                                <label for="version_name"
                                                       class="form-label">{{ __('resources.update.version.name') }}</label>
                                                <input type="text" class="form-control rounded-1" id="version_name"
                                                       name="version_name" value="{{ old('version_name') }}" required>
                                                @error('version_name')
                                                <div id="version_version_error"
                                                     class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label for="version_version"
                                                       class="form-label">{{ __('resources.update.version.version') }}</label>
                                                <input type="text" class="form-control rounded-1" id="version_version"
                                                       name="version_version" value="{{ old('version_version') }}"
                                                       required>
                                                @error('version_version')
                                                <div id="version_version_error"
                                                     class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="my-3">
                                            <label class="form-check-label"
                                                   for="upload_file">{{ __('resources.create.file.name') }}</label>
                                            <input type="file"
                                                   class="form-control rounded-1 mt-2 @error('upload_file') is-invalid @enderror"
                                                   id="upload_file" name="upload_file" required accept=".jar,.zip,.rar">
                                            <small>{{ __('resources.create.file.description') }}</small>
                                            @error('upload_file')
                                            <div id="upload_file_error" class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @include('elements.textarea', ['description' => 'Description', 'row' => 20, 'content' => old('description')])

                                        <button type="submit"
                                                class="btn btn-primary rounded-1 d-block w-100 mt-1">
                                            {{ __('messages.save_update') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
