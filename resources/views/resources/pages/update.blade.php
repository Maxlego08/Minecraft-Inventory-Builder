@extends('resources.layouts.base')

@section('title', "$resource->name | Updates")

@section('resource')
    <div class="bg-blue-800 p-4 show active">
        @foreach($versions as $version)
            <div class="card mb-4 rounded-1 bg-blue-700">
                <div class="card-body">
                    <span class="d-flex align-items-end">
                        <a href="#" class="fs-5 d-block" title="Mise à jour #3">{{ $version->title }}</a>
                        <span class="fs-6 ms-2">{{ $version->version }}</span>
                    </span>
                    <p class="fs-6">{{ \Illuminate\Support\Str::limit($version->description, 500) }}</p>
                    <span class="fs-7">Posté par <span class="text-danger">{{ $version->resource->user->name }}</span>, le {{ format_date($version->created_at, true) }}</span>
                </div>
            </div>
        @endforeach
    </div>
@endsection
