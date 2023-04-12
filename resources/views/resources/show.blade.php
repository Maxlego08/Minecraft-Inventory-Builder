@extends('resources.layouts.base')

@section('title', 'GroupeZ')

@section('resource')
    <div class="bg-blue-800 p-4 show active">
        <ul class="nav text-muted">
            <li><span>Version de Minecraft testées:</span> <span>1.7, 1.8, 1.9, 1.10, 1.11, 1.12, 1.13, 1.14, 1.15, 1.16, 1.17, 1.18, 1.19</span>
            </li>
            <li><span>Langues supportées:</span> <span>Français, English, Italiano, Español, Deutsch</span>
            </li>
        </ul>

        <div class="pt-3 mb-0 resource-content">
            {!! $resource->toHTML() !!}
        </div>
    </div>

    <div class="bg-blue-800 p-4 show active mt-3">
        <div class="mb-3">
            <span class="fs-5">{{ __('resources.reviews.recent') }}</span>
        </div>
        @if (sizeof($reviews) == 0)
            <div class="alert alert-danger rounded-0" role="alert">{{ __('resources.reviews.no') }}</div>
        @else
            @foreach ($reviews as $review)
                @include('resources.elements.review', ['review' => $review])
            @endforeach
        @endif
        <div class="d-flex justify-content-end">
            <a class="fs-7 text-secondary"
               href="{{ $resource->link('reviews') }}">{{ __('resources.reviews.read-all') }}</a>
        </div>
    </div>

@endsection
