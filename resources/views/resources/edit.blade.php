@extends('layouts.base')

@section('title', 'GroupeZ')

@section('app')
    <div class="content_resources_show py-5 mb-5">
        <div class="px-3 px-lg-0">
            <div class="container">
                <div class="card mb-3 rounded-1">
                    <div class="card-body">
                        <h4 class="fw-bold fs-5 mb-0">{{ __('resources.edit.title') }}</h4>
                            <p class="mb-0">{{ __('resources.edit.description') }}</p>
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
                        <form action="{{ route('resources.edit.store', ['resource' => $resource]) }}" method="POST">
                            @method('POST')
                            @csrf
                            @include('resources.elements._form_edit')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
