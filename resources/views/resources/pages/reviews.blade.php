@extends('resources.layouts.base')

@section('title', "$resource->name | Reviews")

@section('resource')
    <div class="bg-blue-800 p-4 show active">
        @if (sizeof($reviews) == 0)
            <div class="alert alert-danger rounded-1" role="alert">{{ __('resources.reviews.no') }}</div>
        @else
            @foreach ($reviews as $review)
                @include('resources.elements.review', ['review' => $review])
            @endforeach
            {!! $reviews->links('elements.pagination') !!}
        @endif
    </div>
@endsection
