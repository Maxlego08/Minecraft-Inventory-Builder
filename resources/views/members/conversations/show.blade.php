@extends('members.layouts.app')

@section('title', __('conversations.show.title', ['title' => $conversation->subject]))

@section('content-member')
    <div class="card rounded-1 mt-3 mb-3">
        <div class="card-body">
            <h2>{{ $conversation->subject }}</h2>
        </div>
    </div>
    {{ $messages->links('elements.pagination') }}
    <div class="conversations">
        @foreach($messages as $message)
            @include('members.conversations.conversation', ['message' => $message])
        @endforeach
    </div>
    {{ $messages->links('elements.pagination') }}
    <div class="card rounded-1 mt-3 mb-3">

        <div class="p-2">

            <div id="bbcodePreview"></div>

            <form method="POST" action="{{ route('profile.conversations.post', $conversation) }}">
                @csrf
                @include('elements.textarea')
                <button type="submit" class="btn btn-primary rounded-1 d-block"><i
                        class="bi bi-send"></i> {{ __('conversations.textarea.submit') }}</button>
            </form>
        </div>
    </div>
@endsection


