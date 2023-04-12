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
                            <span class="text-muted fw-light fs-7 ms-1 text-nowrap">{{ __('resources.versions.version') }}: {{ $review->version->version }}
                            </span>
                            <p class="mt-1 mb-1">{{ $review->review }}</p>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted fs-7 fw-light">{{ format_date($review->created_at) }}</span>
                                @auth
                                    @if (user()->role->isModerator())
                                        <form action="{{ route('resources.review.delete', ['review' => $review]) }}"
                                              method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger"><i
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
                        <div class="ms-3">
                            <a href="{{ $resource->user->authorPage() }}"
                               class="fw-bold text-decoration-none text-warning"
                               title="{{ $resource->user->name }}">{{ $resource->user->name }}
                                <div class="badge bg-warning ms-2"> {{ __('resources.reviews.author') }}</div>
                            </a>
                            <p class="mt-1 mb-1">{{ $review->response }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
    {!! $reviews->links('elements.pagination') !!}
@endsection
