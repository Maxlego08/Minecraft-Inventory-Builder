@extends('layouts.base')

@section('title', $user->name)

@section('app')
    <div class="content_resources_add py-5 mb-5">
        <div class="container">
            <div class="px-0 px-lg-0">
                <div class="row my-4">
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-md-6 col-lg-12">
                                <div class="card mb-3 rounded-1">
                                    <div class="card-header d-flex justify-content-center align-items-center">
                                        <img src="{{ $user->getProfilePhotoUrlAttribute() }}" height="50" width="50"
                                             alt="{{ $user->name }}" class="rounded-2">
                                        <span class="d-lg-block ms-2">{{ $user->name }}</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <p>{{ __('messages.resources') }}:</p>
                                            <p>{{ $resources_count }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-12">
                                @include('resources.elements.sponsor')
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-9">
                        @foreach($resources as $resource)
                            @include('resources.elements.resource', ['resource' => $resource])
                        @endforeach
                        {!! $resources->links('elements.pagination') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
