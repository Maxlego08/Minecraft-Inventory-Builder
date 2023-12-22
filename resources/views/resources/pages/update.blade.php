@php use Illuminate\Support\Str; @endphp
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
                    <p class="fs-6">{{ Str::limit($version->description, 500) }}</p>
                    <div class="fs-7 d-flex mb-2">
                        <div>{!! $version->resource->cache('user')->displayNameAndLink() !!}</div>
                        , {{ format_date($version->created_at, true) }}</div>
                    @include('elements.likeable', ['likeable' => $version, 'url' => route('like.version', $version)])
                </div>
            </div>
        @endforeach
    </div>
@endsection
