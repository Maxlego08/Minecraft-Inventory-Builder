 @extends('resources.layouts.dashboard')

@section('title', __('resources.dashboard.resource.title'))

@section('dashboard-section')
    @foreach($resources as $resource)
        @include('resources.elements.resource', ['resource' => $resource])
    @endforeach
    {!! $resources->links('elements.pagination') !!}
@endsection
