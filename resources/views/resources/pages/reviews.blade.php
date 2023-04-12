@extends('resources.layouts.base')

@section('title', "$resource->name | Reviews")

@section('resource')
    @foreach ($reviews as $review)
        <div class="mb-2">
            <div class="card rounded-0 bg-blue-700">
                <div class="card-body p-2">
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <a href="{{ $review->user->authorPage() }}" title="{{ $review->user->name }} profile"
                           class="d-flex align-items-center">
                            <img class="rounded-circle" width="50" height="50"
                                 src="{{ $review->user->getProfilePhotoUrlAttribute() }}"
                                 alt="{{ $review->user->name }} Avatar">
                        </a>
                        <div class="ms-3 w-100">
                            <a href="{{ $review->user->authorPage() }}" class="fw-bold text-decoration-none"
                               title="{{ $review->user->name }}">{{ $review->user->name }}</a>
                            <span class="d-inline-flex text-warning ms-1">{!! $review->reviewScore() !!}</span>
                            <span class="text-muted fw-light fs-8 ms-1 text-nowrap">{{ __('resources.versions.version') }}: {{ $review->version->version }}
                            </span>
                            <p class="mt-1 mb-1 fs-7">{{ $review->review }}</p>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted fs-8 fw-light">{{ format_date($review->created_at) }}</span>
                                @auth
                                    @if ($review->isModerator())
                                        <form action="{{ route('resources.review.delete', ['review' => $review]) }}"
                                              method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                    class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @if ($review->response)
                    <div class="ms-5 block_resources_description my-2 d-flex flex-row flex-wrap flex-sm-nowrap">
                        <a href="{{ $resource->user->authorPage() }}" title="{{ $resource->user->name }} profile"
                           class="d-flex align-items-center">
                            <img class="rounded-circle" width="50" height="50"
                                 src="{{ $resource->user->getProfilePhotoUrlAttribute() }}"
                                 alt="{{ $resource->user->name }} Avatar">
                        </a>
                        <div class="ms-3 w-100">
                            <a href="{{ $resource->user->authorPage() }}"
                               class="fw-bold text-decoration-none text-warning"
                               title="{{ $resource->user->name }}">{{ $resource->user->name }}
                                <div class="badge bg-warning ms-2"> {{ __('resources.reviews.author') }}</div>
                            </a>
                            <p class="mt-1 mb-1 fs-7">{{ $review->response }}</p>
                            @if($resource->isModerator())
                                <div class="d-flex justify-content-end me-2">
                                    <form method="post"
                                          action="{{ route('resources.review.response', ['review' => $review]) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    @auth
                        @if ($resource->user_id === user()->id)
                            <div class="d-flex justify-content-end p-2">
                                <span type="button" class="text-warning" data-bs-toggle="modal"
                                      data-bs-target="#responseModal{{ $review->id }}">
                                        <i class="bi bi-arrow-90deg-left"></i> {{ __('resources.reviews.reply.message') }}
                                </span>

                                <div class="modal fade" id="responseModal{{ $review->id }}" tabindex="-1"
                                     aria-labelledby="responseModal{{ $review->id }}Label"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="exampleModalLabel">{{ __('resources.reviews.reply.title') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <form method="post"
                                                  action="{{ route('resources.review.reply', ['review' => $review]) }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="message"
                                                               class="col-form-label">{{ __('messages.message') }}
                                                            :</label>
                                                        <textarea class="form-control rounded-0" style="resize: none;"
                                                                  rows="5" minlength="3"
                                                                  id="message" name="message"></textarea>
                                                        @error('message')
                                                        <div id="message_error"
                                                             class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary rounded-0 btn-sm"
                                                            data-bs-dismiss="modal">
                                                        {{ __('messages.close') }}
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-primary rounded-0 btn-sm">{{ __('resources.reviews.reply.title') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    @endforeach
    {!! $reviews->links('elements.pagination') !!}
@endsection
