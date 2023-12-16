@extends('layouts.base')

@section('title', "Resources")

@section('app')
    <div class="content_resources_add mb-5">
        <div class="container">
            <div class="px-0 px-lg-0">
                <div class="block_resources_add card my-4 rounded-1">
                    <div class="card-body px-4">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <h1 class="fw-bold fs-3">{{ __('resources.title') }}</h1>
                                <p>{{ __('resources.description') }}</p>
                            </div>
                            <div class="col-lg-4 offset-lg-1">
                                <a href="{{route('resources.create.index')}}"
                                   class="btn btn-primary btn-sm rounded-1 d-flex align-items-center justify-content-center"><i
                                        class="bi bi-plus-lg me-2 fs-6"></i>{{ __('resources.add') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-lg-3">
                        <div class="row">
                            @include('resources.elements.actions')
                            @include('resources.elements.categories')
                            @include('resources.elements.users')
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
