@extends('layouts.base')

@section('title', 'Post Resource Update')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="px-3 px-lg-0">
            <div class="container">
                <div class="card mb-3 rounded-1">
                    <div class="card-body">
                        <h4 class="fw-bold fs-5 mb-0">{{ __('resources.update.info.title') }}</h4>
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
                        <form action="{{ route('resources.update.store', ['resource' => $resource]) }}" method="POST" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="row">
                                        @include('resources.elements._form_update', ['resource' => $resource])
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
