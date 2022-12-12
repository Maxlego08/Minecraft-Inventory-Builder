@extends('members.layouts.app')

@section('title', __('conversations.show.title', ['title' => $conversation->subject]))

@section('content-member')
    <div class="card rounded-0 mt-3 mb-3">
        <div class="card-body">
            <h2>{{ $conversation->subject }}</h2>
        </div>
    </div>
    @foreach($conversation->messages as $message)
        <div class="card rounded-0 mt-3 mb-3">
            <div class="card-body">
                {!! $message->toHTML() !!}
            </div>
        </div>
    @endforeach
    <div class="card rounded-0 mt-3 mb-3">
        <div class="card-body">
            <form method="POST" class="d-flex flex-column">
                <label for="description">{{ __('conversations.textarea.label') }}</label>
                <textarea id="description" name="description"
                          required rows="12" style="resize: vertical;" maxlength="5000"
                          class="form-input mb-2 @error('description') invalid @enderror">{{ old('description') }}</textarea>

                <div class="d-flex justify-content-center">
                    <button class="btn btn-success">{{ __('conversations.textarea.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('footer-scripts')
    @vite(['resources/js/editor/editor.js'])
@endpush


