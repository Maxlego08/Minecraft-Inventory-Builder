@extends('layouts.base')

@section('title', $user->name)

@section('app')
    <div class="content_resources_add py-5 mb-5">
        <div class="container">
            <div class="px-0 px-lg-0">
                <div class="block_resources_add card my-4 rounded-1">
                    <div class="card-body px-4">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <h1 class="fw-bold fs-3">{{ $user->name }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
