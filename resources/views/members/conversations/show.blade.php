@extends('members.layouts.app')

@section('title', __('conversations.show.title', ['title' => $conversation->subject]))

@section('content-member')
    <div class="card rounded-0 mt-3 mb-3">
        <div class="card-body">
            <h2>{{ $conversation->subject }}</h2>
        </div>
    </div>
    <div class="conversations">
        @foreach($conversation->messages as $message)
            @include('members.conversations.conversation', ['message' => $message])
        @endforeach
    </div>
    <div class="card rounded-0 mt-3 mb-3">
        <div class="p-2">
            <form method="POST" action="{{ route('profile.conversations.post', $conversation) }}">
                @csrf
                <div class="mb-3">
                    <textarea id="description" name="description"
                              required rows="12" style="resize: vertical;" maxlength="5000"
                              class="form-input mb-2 @error('description') invalid @enderror">{{ old('description') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary rounded-0 d-block"><i
                        class="bi bi-send"></i> {{ __('conversations.textarea.submit') }}</button>
            </form>
        </div>
    </div>
@endsection

@push('footer-scripts')
    @vite(['resources/js/editor/editor.js'])
@endpush


