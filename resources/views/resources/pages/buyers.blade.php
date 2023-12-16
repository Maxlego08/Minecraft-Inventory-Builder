@extends('resources.layouts.base')

@section('title', "$resource->name | Updates")

@section('resource')
    <div class="bg-blue-800 p-4 show active">
        <form action="{{ route('resources.buyers', ['resource' => $resource, 'slug' => $resource->slug() ]) }}" method="get" class="mb-2">
            <div class="mb-3">
                <label for="search" class="form-label rounded-1">{{ __('resources.buyers.search') }}</label>
                <input type="text" class="form-control rounded-1" id="search" name="search">
            </div>
        </form>
        <div class="mb-2">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalBuyers">
                {{ __('resources.buyers.add') }}
            </button>

            <div class="modal fade" id="modalBuyers" tabindex="-1" aria-labelledby="modalBuyersLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('resources.buyers.add') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="{{ route('resources.buyers.create', ['resource' => $resource]) }}">
                            @csrf
                        <div class="modal-body">
                            <label for="username" class="form-label rounded-1">{{ __('resources.buyers.username') }}</label>
                            <input type="text" class="form-control rounded-1" id="username" name="username" data-url="{{ route('api.v1.resources.user') }}">

                            <div class="mt-1 mb-1 d-flex flex-column" id="result"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                            <button type="submit" class="btn btn-primary btn-sm">{{ __('messages.save') }}</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr class="text-muted">
                    <th scope="col" class="fw-light">{{ __('resources.buyers.user') }}</th>
                    <th scope="col" class="fw-light">{{ __('resources.buyers.price') }}</th>
                    <th scope="col" class="fw-light">{{ __('resources.buyers.added_on') }}</th>
                    <th scope="col" class="fw-light"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($buyers as $buyer)
                    <tr>
                        <th class="d-flex align-items-center">
                            <a href="{{ $buyer->user->authorPage() }}"
                               title="{{ $buyer->user->name }} profile">
                                <img class=" rounded-circle"
                                     src="{{ $buyer->user->getProfilePhotoUrlAttribute() }}"
                                     alt="{{ $buyer->user->name }} Avatar" width="30" height="30">
                            </a>
                            <a href="{{ $buyer->user->authorPage() }}" class="fw-bold text-decoration-none d-block ms-3"
                               title="{{ $buyer->user->name }} username">{!! $buyer->user->displayName() !!}</a>
                        </th>
                        <th>{{ $buyer->getPrice() }}</th>
                        <th>{{ format_date($buyer->created_at, true) }}</th>
                        <th>
                            @if ($buyer->payment_id == null)
                                <a href="{{ route('resources.buyers.remove', ['resource' => $resource, 'buyer' => $buyer]) }}"><i class="bi bi-x-lg text-danger"></i></a>
                            @endif
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('footer-scripts')
    @vite(['resources/js/userautocomplete.js'])
@endpush
