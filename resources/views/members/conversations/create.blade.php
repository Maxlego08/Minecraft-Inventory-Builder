@extends('members.layouts.app')

@section('title', __('conversations.create.title', ['user' => $target->name]))

@section('content-member')
    <div class="card rounded-0 mt-3 mb-3">
        <div class="card-body">
            <span>{{ __('conversations.create.start', ['user' => $target->name]) }}</span>
        </div>
    </div>
    <div class="card rounded-0 mt-3 mb-3">
        <div class="p-2">
            <form method="POST" action="{{ route('profile.conversations.store', $target) }}">
                @csrf

                <div class="mb-3">
                    <label for="subject" class="form-label">{{ __('conversations.create.subject') }}</label>
                    <input type="text" class="form-control rounded-0 @error('subject') is-invalid @enderror"
                           id="subject" name="subject" value="{{ old('subject', '') }}">
                    @error('subject')
                    <div id="subject-error"
                         class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="bbcodePreview"></div>

                @include('elements.textarea')
                <button type="submit" class="btn btn-primary rounded-0 d-block"><i
                        class="bi bi-send"></i> {{ __('conversations.create.button') }}</button>
            </form>
        </div>
    </div>
@endsection

@push('footer-scripts')
    @vite(['resources/js/editor/editor.js'])
@endpush


