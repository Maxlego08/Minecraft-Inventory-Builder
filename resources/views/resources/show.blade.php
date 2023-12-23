@extends('resources.layouts.base')

@section('title', $resource->name)

@section('resource')
    <div class="bg-blue-800 p-4 show active">
        <ul class="nav text-muted d-flex flex-column">
            @if($resource->versions)
                <li>
                    <span>{{ __('resources.tested_versions') }}:</span>
                    <span>{{ $resource->getSupportedVersions()  }}</span>
                </li>
            @endif
            @if($resource->lang_support)
                <li>
                    <span>{{ __('resources.lang_support') }}:</span>
                    <span>{{ $resource->lang_support }}</span>
                </li>
            @endif
            @if($resource->contributors)
                <li>
                    <span>{{ __('resources.contributors') }}:</span>
                    <span>{{ $resource->contributors }}</span>
                </li>
            @endif
            @if($resource->source_code_link)
                <li>
                    <span>{{ __('resources.code') }}:</span>
                    <a href="{{ $resource->source_code_link }}" target="_blank">{{ $resource->source_code_link }}</a>
                </li>
            @endif
            @if($resource->link_information)
                <li>
                    <span>{{ __('resources.informations') }}:</span>
                    <a href="{{ $resource->link_information }}" target="_blank">{{ $resource->link_information }}</a>
                </li>
            @endif
            @if($resource->link_support)
                <li>
                    <span>{{ __('resources.link_support') }}:</span>
                    <a href="{{ $resource->link_support }}" target="_blank">{{ $resource->link_support }}</a>
                </li>
            @endif
            @if($resource->required_dependencies)
                <li>
                    <span>{{ __('resources.required_dependencies') }}:</span>
                    {!! dependencies($resource->required_dependencies) !!}
                </li>
            @endif
            @if($resource->optional_dependencies)
                <li>
                    <span>{{ __('resources.optional_dependencies') }}:</span>
                    {!! dependencies($resource->optional_dependencies) !!}
                </li>
            @endif
        </ul>

        <div class="pt-3 mb-0 resource-content">
            {!! $resource->toHTML() !!}
        </div>
        @include('elements.likeable', ['likeable' => $resource, 'url' => route('like.resource', $resource)])
        @auth()
            <!-- Report Modal -->
            <div class="modal fade" id="reportModal{{ $resource->id }}" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reportModalLabel">{{ __('reports.modal_title') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="reportForm" action="{{ route('report.resource', $resource) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="reportReason" class="form-label">{{ __('reports.modal_reason_label') }}</label>
                                    <textarea class="form-control rounded-1" id="reportReason" name="reason" rows="3" minlength="10" maxlength="2000" required placeholder="{{ __('reports.modal_reason_placeholder') }}"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('reports.modal_close_button') }}</button>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-send"></i> {{ __('reports.modal_submit_button') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endauth
    </div>

    <div class="bg-blue-800 p-4 show active mt-3">
        <div class="mb-3">
            <span class="fs-5">{{ __('resources.reviews.recent') }}</span>
        </div>
        @if (sizeof($reviews) == 0)
            <div class="alert alert-danger rounded-1" role="alert">{{ __('resources.reviews.no') }}</div>
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
