@extends('layouts.base')

@section('title', 'Create new resource')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="px-3 px-lg-0">
            <div class="container">
                <div class="card rounded-1 mb-3">
                    <div class="card-body">
                        <h1 class="fw-bold fs-5 mb-0">{{ __('resources.create.info.title') }}</h1>
                        <p class="mb-0">{{ __('resources.create.info.description') }}</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card rounded-1">
                    <div class="card-body">
                        <form action="{{ route('resources.create.store') }}" method="POST"
                              enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            @include('resources.elements._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
