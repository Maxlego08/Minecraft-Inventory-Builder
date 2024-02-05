@extends('members.layouts.app')

@section('title', __('images.title'))

@section('content-member')

    <div class="card rounded-1 mt-3 mb-3">
        <div class="card-body">
            <h5>{{ __('images.upload.title') }}</h5>
            <form method="post" action="{{ route('profile.images.store.redirect')}}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <input type="file" class="form-control rounded-1 mt-2 @error('images') is-invalid @enderror"
                           name="images[]" id="images" accept="{{ user()->role->getImageAcceptInput() }}" multiple
                           required>
                    @error('images')
                    <div id="image_error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                        class="btn btn-primary btn-sm rounded-1 d-flex align-items-center justify-content-center"> {{ __('images.upload.button') }}</button>
            </form>
        </div>
    </div>


    <div class="card rounded-1 mt-3 mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <h4>{{ __('images.title') }}</h4>
                <span>(<span
                        style="color: {{ user()->getDiskColor() }}">{{ human_filesize(user()->getDiskSize()) }}</span>/{{ human_filesize(user()->role->total_size) }})</span>
            </div>
            <div class="table-responsive">
                <div id="deleteSelectedButton" style="display: none">
                    <div class="d-flex justify-content-center">
                        <button type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModalAll"
                                class="btn btn-danger btn-sm rounded-1 d-flex align-items-center justify-content-center">
                            {{ __('images.table.delete_all') }} <i class="bi bi-trash ms-1"></i>
                        </button>
                    </div>
                    <div class="modal fade" id="deleteModalAll" tabindex="-1"
                         aria-labelledby="deleteModalLabelAll" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content rounded-1">
                                <div class="modal-header">
                                    <h5 class="modal-title text-white"
                                        id="deleteModalLabel">{{ __('images.modal.title') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-white">
                                    {{ __('images.modal.content_all') }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button"
                                            class="btn btn-secondary btn-sm rounded-1 d-flex align-items-center justify-content-center"
                                            data-bs-dismiss="modal"> {{ __('messages.close') }}</button>
                                    <button type="submit" id="confirmDeleteAll"
                                            data-url="{{ route('profile.images.delete.all') }}"
                                            data-token="{{ csrf_token() }}"
                                            class="btn btn-danger btn-sm rounded-1 d-flex align-items-center justify-content-center"> {{ __('images.table.delete') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table image-table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('images.table.name') }}</th>
                        <th scope="col">{{ __('images.table.size') }}</th>
                        <th scope="col">{{ __('messages.created_at') }}</th>
                        <th scope="col" style="width: 10%">{{ __('images.table.action') }}</th>
                    </tr>
                    </thead>
                    <tbody class="table-striped">
                    @foreach($images as $image)
                        <tr id="image-{{ $image->id }}">
                            <th scope="row">
                                <a href="{{ $image->getPath() }}" target="_blank">
                                    <img src="{{ route('image.preview', $image) }}" alt="Image #{{ $image->id }}"
                                         title="{{ __('images.alt') }}">
                                </a>
                            </th>
                            <td>{{ $image->file_upload_name }}</td>
                            <td>{{ human_filesize($image->file_size) }}</td>
                            <td>{{ format_date($image->created_at, true) }}</td>
                            <td>
                                @if($image->is_deletable)
                                    <div class="d-flex justify-content-evenly">
                                        <button type="button"
                                                class="btn btn-danger btn-sm rounded-1 d-flex align-items-center justify-content-center"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $image->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <div class="modal fade" id="deleteModal{{ $image->id }}" tabindex="-1"
                                             aria-labelledby="deleteModalLabel{{ $image->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content rounded-1">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-white"
                                                            id="deleteModalLabel">{{ __('images.modal.title') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-white">
                                                        {{ __('images.modal.content') }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                                class="btn btn-secondary btn-sm rounded-1 d-flex align-items-center justify-content-center"
                                                                data-bs-dismiss="modal"> {{ __('messages.close') }}</button>
                                                        <form method="post"
                                                              action="{{ route('profile.images.delete', ['file' => $image]) }}">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="btn btn-danger btn-sm rounded-1 d-flex align-items-center justify-content-center"> {{ __('images.table.delete') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="checkbox" class="image-checkbox" name="images[]" data-id="{{ $image->id }}"
                                               id="deleteSelectedButton"
                                               value="{{ $image->id }}">
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
