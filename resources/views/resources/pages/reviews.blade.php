@extends('resources.layouts.base')

@section('title', "$resource->name | Reviews")

@section('resource')
    <div class="bg-blue-800 p-4 show active">
        @foreach ($reviews as $review)
            @include('resources.elements.review', ['review' => $review])
        @endforeach
        {!! $reviews->links('elements.pagination') !!}
    </div>
@endsection
