@extends('members.layouts.app')

@section('title', __('profiles.change.title'))

@section('content-member')

    <div class="card rounded-1 mt-3 mb-3">
        <div class="card-body">

            <form action="{{ route('profile.name.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('profiles.change.new_name') }}</label>
                    <input class="form-control rounded-1 @error('name') is-invalid @enderror" type="text" id="name"
                           name="name" required>
                    @error('name')
                    <div id="name-error" class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small>{{ __('profiles.change.info') }}</small>
                </div>

                <button class="btn btn-primary btn-sm rounded-1 d-block w-100 mt-2"
                        type="submit">{{ __('messages.save') }}</button>
            </form>

        </div>
    </div>

    <div class="card rounded-1 mt-3 mb-3">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('profiles.change.old_name') }}</th>
                        <th>{{ __('profiles.change.new_name') }}</th>
                        <th>{{ __('messages.update_at') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach(user()->nameChangeHistories->sortByDesc('created_at') as $changeHistory)
                            <tr>
                                <td>{{ $changeHistory->old_name }}</td>
                                <td>{{ $changeHistory->new_name }}</td>
                                <td>{{ format_date($changeHistory->created_at) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
