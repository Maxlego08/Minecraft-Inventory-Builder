@extends('resources.layouts.base')

@section('title', "$resource->name | Updates")

@section('resource')
    <div class="card mb-4 rounded-1">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr class="text-muted">
                        <th scope="col" class="fw-light">{{ __('resources.versions.version') }}</th>
                        <th scope="col" class="fw-light">{{ __('messages.released_at') }}</th>
                        <th scope="col" class="fw-light">{{ __('messages.downloads') }}</th>
                        <th scope="col" class="fw-light">{{ __('messages.average_rating') }}</th>
                        <th scope="col" class="fw-light"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($versions as $version)
                        <tr>
                            <th scope="row" class="fw-normal">{{ $version->version }}</th>
                            <td>{{ format_date($version->created_at, true) }}</td>
                            <td>{{ $version->download }}</td>
                            <td class="text-nowrap">
                            <span class="text-warning text-nowrap">
                                 {!! $version->reviewScore() !!}
                            </span>
                                <span class="ms-2">{{ $version->reviews->count() }}</span>
                            </td>
                            <td><a href="{{ $version->download() }}" class="btn btn-secondary btn-sm fw-light">{{ __('messages.download') }}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $versions->links('elements.pagination') !!}
            </div>
        </div>
    </div>
@endsection
